<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\CateringOrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class CateringOrderController extends Controller
{
    public function create(string $slug)
    {
        $menu = Menu::query()
            ->where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        if (
            $menu->available_stock !== null
            && (int) $menu->available_stock < 1
        ) {
            return redirect()
                ->route('catering-menus.show', $menu->slug)
                ->with('error', 'Ce menu n’est plus disponible.');
        }

        $user = Auth::user();

        return view(
            'frontend.pages.catering-orders.create',
            compact('menu', 'user')
        );
    }


    
    public function store(Request $request, string $slug)
    {
        $menu = \App\Models\Menu::query()
            ->where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:2000'],
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'delivery_time' => ['required', 'date_format:H:i'],
            'service_location' => ['required', 'string', 'max:255'],
            'number_of_persons' => [
                'required',
                'integer',
                'min:' . (int) $menu->minimum_persons,
            ],
        ]);

        if (
            $menu->available_stock !== null
            && (int) $menu->available_stock < 1
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'menu' => 'Ce menu n’est plus disponible.',
                ]);
        }

        $persons = (int) $validated['number_of_persons'];

        // Le prix du menu est un prix total, pas un prix par personne.
        $menuPrice = round((float) $menu->price, 2);

        $discount = $persons >= ((int) $menu->minimum_persons + 5)
            ? round($menuPrice * 0.10, 2)
            : 0;

        /*
        * Valeur provisoire pour les tests.
        * À remplacer par le calcul réel de distance avant la production.
        */
        $deliveryFee = 5.00;

        $grandTotal = round(
            $menuPrice - $discount + $deliveryFee,
            2
        );

        $order = DB::transaction(function () use (
            $validated,
            $menu,
            $persons,
            $menuPrice,
            $discount,
            $deliveryFee,
            $grandTotal
        ) {
            $order = new Order();

            $order->invoice_id = generateInvoiceId();
            $order->user_id = Auth::id();

            $order->catering_menu_id = $menu->id;
            $order->delivery_date = $validated['delivery_date'];
            $order->delivery_time = $validated['delivery_time'];
            $order->number_of_persons = $persons;

            $order->catering_first_name = $validated['first_name'];
            $order->catering_last_name = $validated['last_name'];
            $order->catering_email = $validated['email'];
            $order->catering_phone = $validated['phone'];
            $order->service_location = $validated['service_location'];

            $order->address = $validated['address'];
            $order->discount = $discount;
            $order->delivery_charge = $deliveryFee;
            $order->subtotal = $menuPrice;
            $order->grand_total = $grandTotal;

            // Une commande de menu : une ligne de commande.
            $order->product_qty = 1;

            $order->payment_method = null;
            $order->payment_status = 'pending';
            $order->order_status = 'pending';

            $order->save();

            $item = new OrderItem();
            $item->order_id = $order->id;
            $item->product_name = $menu->title;
            $item->product_id = null;
            $item->unit_price = $menuPrice;
            $item->qty = 1;
            $item->product_size = null;
            $item->product_option = null;
            $item->save();

            return $order;
        });


        try {
            Mail::to($order->catering_email)
                ->send(new CateringOrderConfirmation($order));
        } catch (\Throwable $e) {
            Log::error('Échec de l’e-mail de confirmation traiteur', [
                'order_id' => $order->id,
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('catering-orders.create', $menu->slug)
            ->with(
                'success',
                'Votre commande a été enregistrée. Référence : '
                    . $order->invoice_id
                    . '. Le paiement et la confirmation définitive restent à configurer.'
            );
    }




    
    public function edit(int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->whereNotNull('catering_menu_id')
            ->findOrFail($id);

        if ($order->order_status !== 'pending') {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $menu = $order->cateringMenu;
        $user = Auth::user();

        if (!$menu) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Le menu de cette commande est introuvable.');
        }

        return view(
            'frontend.pages.catering-orders.edit',
            compact('order', 'menu', 'user')
        );
    }

    public function update(Request $request, int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->whereNotNull('catering_menu_id')
            ->findOrFail($id);

        if ($order->order_status !== 'pending') {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $menu = $order->cateringMenu;

        if (!$menu) {
            return back()->with('error', 'Le menu est introuvable.');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:2000'],
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'delivery_time' => ['required', 'date_format:H:i'],
            'service_location' => ['required', 'string', 'max:255'],
            'number_of_persons' => [
                'required',
                'integer',
                'min:' . (int) $menu->minimum_persons,
            ],
        ]);

        $persons = (int) $validated['number_of_persons'];
        $menuPrice = round((float) $menu->price, 2);

        $discount = $persons >= ((int) $menu->minimum_persons + 5)
            ? round($menuPrice * 0.10, 2)
            : 0;

        // Même calcul provisoire que lors de la création.
        $deliveryFee = (float) $order->delivery_charge;
        $grandTotal = round(
            $menuPrice - $discount + $deliveryFee,
            2
        );

        DB::transaction(function () use (
            $order,
            $validated,
            $persons,
            $menuPrice,
            $discount,
            $deliveryFee,
            $grandTotal,
            $menu
        ) {
            $order->catering_first_name = $validated['first_name'];
            $order->catering_last_name = $validated['last_name'];
            $order->catering_email = $validated['email'];
            $order->catering_phone = $validated['phone'];
            $order->address = $validated['address'];
            $order->delivery_date = $validated['delivery_date'];
            $order->delivery_time = $validated['delivery_time'];
            $order->service_location = $validated['service_location'];
            $order->number_of_persons = $persons;

            $order->subtotal = $menuPrice;
            $order->discount = $discount;
            $order->delivery_charge = $deliveryFee;
            $order->grand_total = $grandTotal;

            $order->save();

            $item = OrderItem::where('order_id', $order->id)->first();

            if ($item) {
                $item->product_name = $menu->title;
                $item->unit_price = $menuPrice;
                $item->qty = 1;
                $item->save();
            }
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Votre commande traiteur a été modifiée avec succès.');
    }














}
