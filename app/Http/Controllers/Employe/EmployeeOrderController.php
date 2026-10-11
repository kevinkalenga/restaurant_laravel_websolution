<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeOrderController extends Controller
{
    /**
     * Afficher le détail d'une commande et son historique.
     */
    public function show(Order $order)
    {
        $order->load([
            'user',
            'orderItems',
            'statusHistories.employee',
        ]);

        return view('employe.orders.show', compact('order'));
    }

    /**
     * Modifier le statut selon les transitions autorisées.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => [
                'required',
                'string',
                Rule::in([
                    'pending',
                    'accepted',
                    'in_process',
                    'in_delivery',
                    'delivered',
                    'waiting_equipment_return',
                    'completed',
                    'cancelled',
                ]),
            ],

            // Informations obligatoires en cas d'annulation.
            
            'contact_confirmed' => [
                'exclude_unless:order_status,cancelled',
                'required',
                'accepted',
            ],

            
            'contact_method' => [
                'required_if:order_status,cancelled',
                Rule::in(['phone', 'email', 'sms', 'in_person']),
            ],
            'cancellation_reason' => [
                'required_if:order_status,cancelled',
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $newStatus = $validated['order_status'];

        $result = DB::transaction(function () use (
            $order,
            $newStatus,
            $validated
        ) {
            // Verrouille la commande pendant la vérification et la mise à jour.
            $currentOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldStatus = $currentOrder->order_status;

            if ($newStatus === $oldStatus) {
                return [
                    'success' => true,
                    'message' => 'Le statut est inchangé.',
                ];
            }

            // Parcours autorisé de la commande.
            $transitions = [
                'pending' => ['accepted', 'cancelled'],
                'accepted' => ['in_process', 'cancelled'],
                'in_process' => ['in_delivery'],
                'in_delivery' => ['delivered'],
                'delivered' => [
                    'completed',
                    'waiting_equipment_return',
                ],
                'waiting_equipment_return' => [],
                'completed' => [],
                'cancelled' => [],
            ];

            if (!in_array(
                $newStatus,
                $transitions[$oldStatus] ?? [],
                true
            )) {
                return [
                    'success' => false,
                    'message' => 'Cette transition de statut est interdite.',
                ];
            }

            // Une commande avec matériel prêté doit passer par
            // l'étape de restitution avant de pouvoir être terminée.
            if (
                $newStatus === 'completed'
                && $currentOrder->equipment_loaned
            ) {
                return [
                    'success' => false,
                    'message' => 'Le retour du matériel doit être confirmé avant de terminer la commande.',
                ];
            }

            if (
                $newStatus === 'waiting_equipment_return'
                && !$currentOrder->equipment_loaned
            ) {
                return [
                    'success' => false,
                    'message' => 'Cette commande ne comporte pas de matériel prêté.',
                ];
            }

            $note = null;

            if ($newStatus === 'cancelled') {
                $methods = [
                    'phone' => 'Téléphone',
                    'email' => 'E-mail',
                    'sms' => 'SMS',
                    'in_person' => 'En personne',
                ];

                $note = 'Contact préalable confirmé. '
                    . 'Moyen : '
                    . $methods[$validated['contact_method']]
                    . '. Motif : '
                    . $validated['cancellation_reason'];
            }

            $currentOrder->update([
                'order_status' => $newStatus,
            ]);

            OrderStatusHistory::create([
                'order_id' => $currentOrder->id,
                'changed_by' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'note' => $note,
            ]);

            return [
                'success' => true,
                'message' => 'Statut mis à jour et historique enregistré.',
            ];
        });

        return redirect()
            ->route('employe.orders.show', $order->id)
            ->with(
                $result['success'] ? 'success' : 'error',
                $result['message']
            );
    }

    /**
     * Mettre à jour le matériel prêté et confirmer sa restitution.
     */
    public function updateEquipment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'equipment_loaned' => ['required', 'boolean'],
            'equipment_return_confirmed' => ['sometimes', 'accepted'],
        ]);

        $result = DB::transaction(function () use (
            $order,
            $validated
        ) {
            $currentOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $equipmentLoaned = (bool) $validated['equipment_loaned'];

            // La confirmation explicite est requise pour clôturer
            // une commande en attente du retour du matériel.
            if (
                $currentOrder->order_status === 'waiting_equipment_return'
                && $currentOrder->equipment_loaned
                && !$equipmentLoaned
            ) {
                if (
                    !request()->boolean('equipment_return_confirmed')
                ) {
                    return [
                        'success' => false,
                        'message' => 'Coche la confirmation de restitution du matériel avant de terminer la commande.',
                    ];
                }

                $oldStatus = $currentOrder->order_status;

                $currentOrder->update([
                    'equipment_loaned' => false,
                    'order_status' => 'completed',
                ]);

                OrderStatusHistory::create([
                    'order_id' => $currentOrder->id,
                    'changed_by' => auth()->id(),
                    'old_status' => $oldStatus,
                    'new_status' => 'completed',
                    'note' => 'Restitution du matériel confirmée par l’employé.',
                ]);

                return [
                    'success' => true,
                    'message' => 'Retour du matériel confirmé. Commande terminée et historique enregistré.',
                ];
            }

            // Empêche de retirer l'indicateur de prêt pendant
            // une étape où la restitution est encore attendue.
            if (
                $currentOrder->order_status === 'waiting_equipment_return'
                && !$equipmentLoaned
            ) {
                return [
                    'success' => false,
                    'message' => 'Utilise la confirmation de restitution pour terminer cette commande.',
                ];
            }

            $currentOrder->update([
                'equipment_loaned' => $equipmentLoaned,
            ]);

            return [
                'success' => true,
                'message' => 'Information sur le matériel mise à jour.',
            ];
        });

        return redirect()
            ->route('employe.orders.show', $order->id)
            ->with(
                $result['success'] ? 'success' : 'error',
                $result['message']
            );
    }
}
