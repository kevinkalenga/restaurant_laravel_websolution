<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Yajra\DataTables\Facades\DataTables;
use App\Models\OrderStatistic;
use App\Models\OrderStatusHistory;
use App\Mail\EquipmentReturnMail;
use App\Mail\OrderReviewInvitationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\OrderCancellationContactMail;

class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            // Récupère toutes les commandes depuis la table orders
            // et charge en même temps les informations de l'utilisateur associé
            // grâce à la relation "user" définie dans le modèle Order.
            // select('orders.*') permet de sélectionner uniquement les colonnes
            // de la table orders.

            $orders = Order::with('user')->select('orders.*');

            return DataTables::of($orders)

                ->addColumn('user.name', function($order){
                    return $order->user->name ?? 'Guest';
                })



               

                ->addColumn('action', function($order){
                    return '
                        <a href="'.route('admin.orders.show', $order->id).'" 
                        class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-warning edit-order-status"
                                data-id="'.$order->id.'">
                            <i class="fas fa-edit"></i>
                        </button>

                        <a href="'.route('admin.orders.destroy', $order->id).'" 
                        class="btn btn-sm btn-danger delete-item">
                            <i class="fas fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.order.index');
    }

    public function show(Order $order)
    {
        $notification = OrderPlacedNotification::where('order_id', $order->id)->update(['seen' => 1]);
       return view('admin.order.show', compact('order', 'notification'));
    }

   


    // public function updateStatus(Request $request, Order $order)
    // {
    //     $request->validate([
    //         'payment_status' => 'required|in:pending,completed,failed,cancelled',
    //         'order_status' => 'required|in:pending,in_process,delivered,declined',
    //     ]);

    //     $order->update([
    //         'payment_status' => $request->payment_status,
    //         'order_status'   => $request->order_status,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Order status updated successfully.',
    //     ]);
    // }

    
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => [
                'required',
                Rule::in(['pending', 'completed', 'failed', 'cancelled']),
            ],
            'order_status' => [
                'required',
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
            
            'contact_confirmed' => [
                'exclude_unless:order_status,cancelled',
                'required',
                'accepted',
            ],

            'contact_method' => [
                'exclude_unless:order_status,cancelled',
                'required',
                Rule::in(['phone', 'email', 'sms', 'in_person']),
            ],

            'cancellation_reason' => [
                'exclude_unless:order_status,cancelled',
                'required',
                'string',
                'max:1000',
            ],

        ]);

        $newStatus = $validated['order_status'];

        $result = DB::transaction(function () use ($order, $validated, $newStatus) {
            $currentOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldStatus = $currentOrder->order_status;

            if ($oldStatus === $newStatus) {
                return ['success' => true, 'changed' => false,
                    'message' => 'Le statut est inchangé.'];
            }

            $transitions = [
                'pending' => ['accepted', 'cancelled'],
                'accepted' => ['in_process', 'cancelled'],
                'in_process' => ['in_delivery'],
                'in_delivery' => ['delivered'],
                'delivered' => ['completed', 'waiting_equipment_return'],
                'waiting_equipment_return' => [],
                'completed' => [],
                'cancelled' => [],
                'declined' => [],
            ];

            if (!in_array($newStatus, $transitions[$oldStatus] ?? [], true)) {
                return ['success' => false, 'changed' => false,
                    'message' => 'Transition de statut interdite.'];
            }

            if ($newStatus === 'completed' && $currentOrder->equipment_loaned) {
                return ['success' => false, 'changed' => false,
                    'message' => 'Confirme d’abord la restitution du matériel.'];
            }

            if ($newStatus === 'waiting_equipment_return'
                && !$currentOrder->equipment_loaned) {
                return ['success' => false, 'changed' => false,
                    'message' => 'Aucun matériel prêté pour cette commande.'];
            }

            $note = null;

            if ($newStatus === 'cancelled') {
                $methods = [
                    'phone' => 'Téléphone',
                    'email' => 'E-mail',
                    'sms' => 'SMS',
                    'in_person' => 'En personne',
                ];

                $note = 'Contact préalable confirmé. Moyen : '
                    . $methods[$validated['contact_method']]
                    . '. Motif : ' . $validated['cancellation_reason'];
            }

            // Contacter le client par e-mail avant l'annulation.
            if (
                $newStatus === 'cancelled'
                && $validated['contact_method'] === 'email'
            ) {
                $currentOrder->loadMissing('user');

                Mail::to($currentOrder->user->email)
                    ->send(new OrderCancellationContactMail(
                        $currentOrder,
                        $validated['cancellation_reason']
                    ));
            }

            $currentOrder->update([
                'order_status' => $newStatus,
                'payment_status' => $validated['payment_status'],
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
                'changed' => true,
                'message' => 'Statut et paiement mis à jour.',
            ];
        });

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);
        }

        if ($result['changed']) {
            $order->refresh();
            $order->load('user');

            if ($newStatus === 'waiting_equipment_return') {
                Mail::to($order->user->email)
                    ->send(new EquipmentReturnMail($order));
            }

            if ($newStatus === 'completed') {
                Mail::to($order->user->email)
                    ->send(new OrderReviewInvitationMail($order));
            }

            // Conserver les statistiques MongoDB au moment de la livraison.
            if ($newStatus === 'delivered') {
                foreach ($order->orderItems as $item) {
                    $statistic = OrderStatistic::where('menu_id', $item->product_id)
                        ->where('date', now()->format('Y-m-d'))
                        ->first();

                    if ($statistic) {
                        $statistic->increment('total_orders', $item->qty);
                    } else {
                        OrderStatistic::create([
                            'menu_id' => $item->product_id,
                            'menu_name' => $item->product_name,
                            'total_orders' => $item->qty,
                            'date' => now()->format('Y-m-d'),
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'],
        ]);
    }

      
    
    
    
    
    public function getOrderStatus($id)
    {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);
        return response($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
        ]);
    }

    public function pendingOrdersIndex() 
    {
         return view('admin.order.pending-order-index');
    }

    public function pendingOrders()
    {
        $orders = Order::with('user')
            ->where('order_status', 'pending')
            ->select('orders.*');

        return DataTables::of($orders)

            ->addColumn('user.name', function ($order) {
                return $order->user->name ?? 'Guest';
            })

            ->addColumn('action', function ($order) {
                return '
                    <a href="'.route('admin.orders.show', $order->id).'" 
                    class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i>
                    </a>

                    <button type="button"
                            class="btn btn-sm btn-warning edit-order-status"
                            data-id="'.$order->id.'">
                        <i class="fas fa-edit"></i>
                    </button>

                    <a href="'.route('admin.orders.destroy', $order->id).'" 
                    class="btn btn-sm btn-danger delete-item">
                        <i class="fas fa-trash"></i>
                    </a>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
    public function inProcessOrdersIndex() 
    {
         return view('admin.order.inprocess-order-index');
    }

    public function inProcessOrders()
    {
        $orders = Order::with('user')
            ->where('order_status', 'in_process')
            ->select('orders.*');

        return DataTables::of($orders)

            ->addColumn('user.name', function ($order) {
                return $order->user->name ?? 'Guest';
            })

            ->addColumn('action', function ($order) {
                return '
                    <a href="'.route('admin.orders.show', $order->id).'" 
                    class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i>
                    </a>

                    <button type="button"
                            class="btn btn-sm btn-warning edit-order-status"
                            data-id="'.$order->id.'">
                        <i class="fas fa-edit"></i>
                    </button>

                    <a href="'.route('admin.orders.destroy', $order->id).'" 
                    class="btn btn-sm btn-danger delete-item">
                        <i class="fas fa-trash"></i>
                    </a>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function deliveredOrdersIndex() 
    {
         return view('admin.order.delivered-order-index');
    }

    public function deliveredOrders()
    {
        $orders = Order::with('user')
            ->where('order_status', 'delivered')
            ->select('orders.*');

        return DataTables::of($orders)

            ->addColumn('user.name', function ($order) {
                return $order->user->name ?? 'Guest';
            })

            ->addColumn('action', function ($order) {
                return '
                    <a href="'.route('admin.orders.show', $order->id).'" 
                    class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i>
                    </a>

                    <button type="button"
                            class="btn btn-sm btn-warning edit-order-status"
                            data-id="'.$order->id.'">
                        <i class="fas fa-edit"></i>
                    </button>

                    <a href="'.route('admin.orders.destroy', $order->id).'" 
                    class="btn btn-sm btn-danger delete-item">
                        <i class="fas fa-trash"></i>
                    </a>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
    public function declinedOrdersIndex() 
    {
         return view('admin.order.declined-order-index');
    }

    public function declinedOrders()
    {
        $orders = Order::with('user')
            ->where('order_status', 'declined')
            ->select('orders.*');

        return DataTables::of($orders)

            ->addColumn('user.name', function ($order) {
                return $order->user->name ?? 'Guest';
            })

            ->addColumn('action', function ($order) {
                return '
                    <a href="'.route('admin.orders.show', $order->id).'" 
                    class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i>
                    </a>

                    <button type="button"
                            class="btn btn-sm btn-warning edit-order-status"
                            data-id="'.$order->id.'">
                        <i class="fas fa-edit"></i>
                    </button>

                    <a href="'.route('admin.orders.destroy', $order->id).'" 
                    class="btn btn-sm btn-danger delete-item">
                        <i class="fas fa-trash"></i>
                    </a>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
}
