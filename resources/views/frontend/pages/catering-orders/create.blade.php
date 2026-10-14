
@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">
    <h2>Commander un menu traiteur</h2>

    <div class="card p-4 mt-4">
        <h4>{{ $menu->title }}</h4>
        <p>{{ $menu->description }}</p>

        <p>
            Prix total de base du menu :
            <strong>{{ number_format((float) $menu->price, 2, ',', ' ') }} €</strong>
        </p>

        <p>
            Nombre minimum de personnes :
            <strong>{{ $menu->minimum_persons }}</strong>
        </p>

        <p class="text-muted mb-0">
            Le prix du menu correspond au forfait de base et non à un prix par personne.
        </p>
    </div>

    <form
        action="{{ route('catering-orders.store', $menu->slug) }}"
        method="POST"
        id="catering-order-form"
        class="mt-4"
    >
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name">Prénom *</label>
                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    class="form-control"
                    value="{{ old('first_name', $user->name) }}"
                    maxlength="255"
                    autocomplete="given-name"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="last_name">Nom *</label>
                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    class="form-control"
                    value="{{ old('last_name') }}"
                    maxlength="255"
                    autocomplete="family-name"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="email">E-mail *</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    maxlength="255"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone">GSM *</label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone', $user->phone) }}"
                    maxlength="30"
                    autocomplete="tel"
                    required
                >
            </div>

            <div class="col-12 mb-3">
                <label for="address">Adresse de livraison *</label>
                <textarea
                    id="address"
                    name="address"
                    class="form-control"
                    rows="3"
                    maxlength="2000"
                    autocomplete="street-address"
                    required
                >{{ old('address') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label for="delivery_date">Date de prestation *</label>
                <input
                    type="date"
                    id="delivery_date"
                    name="delivery_date"
                    class="form-control"
                    min="{{ now()->toDateString() }}"
                    value="{{ old('delivery_date') }}"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="delivery_time">Heure souhaitée *</label>
                <input
                    type="time"
                    id="delivery_time"
                    name="delivery_time"
                    class="form-control"
                    value="{{ old('delivery_time') }}"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="service_location">Lieu de prestation *</label>
                <input
                    type="text"
                    id="service_location"
                    name="service_location"
                    class="form-control"
                    value="{{ old('service_location') }}"
                    maxlength="255"
                    placeholder="Ex. : salle de réception, entreprise..."
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="number_of_persons">Nombre de personnes *</label>
                <input
                    type="number"
                    id="number_of_persons"
                    name="number_of_persons"
                    class="form-control"
                    min="{{ $menu->minimum_persons }}"
                    step="1"
                    value="{{ old('number_of_persons', $menu->minimum_persons) }}"
                    required
                >
                <small class="text-muted">
                    Minimum : {{ $menu->minimum_persons }} personnes.
                    La réduction de 10 % commence à
                    {{ (int) $menu->minimum_persons + 5 }} personnes.
                </small>
            </div>
        </div>

        <div class="card p-4 mt-3 mb-4">
            <h4>Récapitulatif de votre commande</h4>

            <div class="d-flex justify-content-between py-2">
                <span>Prix total du menu</span>
                <strong id="menu-price">—</strong>
            </div>

            <div class="d-flex justify-content-between py-2">
                <span>Frais de livraison (estimation provisoire)</span>
                <strong id="delivery-price">—</strong>
            </div>

            <div class="d-flex justify-content-between py-2">
                <span>Réduction</span>
                <strong id="discount-price">—</strong>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center">
                <strong>Total estimé</strong>
                <strong class="fs-4" id="grand-total">—</strong>
            </div>

            <small class="text-muted mt-2">
                Les frais de livraison affichés sont provisoirement fixés à 5 €.
                Le calcul définitif selon la distance reste à mettre en place.
            </small>
        </div>

        
        <div class="mb-3">
            <label for="payment_gateway">Moyen de paiement *</label>
            <select
                id="payment_gateway"
                name="payment_gateway"
                class="form-control"
                required
            >
                <option value="paypal" {{ old('payment_gateway', 'paypal') === 'paypal' ? 'selected' : '' }}>
                    PayPal
                </option>
                <option value="stripe" {{ old('payment_gateway') === 'stripe' ? 'selected' : '' }}>
                    Stripe (carte bancaire)
                </option>
            </select>
        </div>
        
        
        <button type="submit" class="common_btn">
            Continuer la commande
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const personsInput = document.getElementById('number_of_persons');

    const menuPrice = {{ (float) $menu->price }};
    const minimumPersons = {{ (int) $menu->minimum_persons }};
    const deliveryFee = 5.00;

    const menuPriceElement = document.getElementById('menu-price');
    const deliveryPriceElement = document.getElementById('delivery-price');
    const discountPriceElement = document.getElementById('discount-price');
    const grandTotalElement = document.getElementById('grand-total');

    const euro = new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    });

    function updatePriceSummary() {
        const persons = Number.parseInt(personsInput.value, 10);

        // La réduction est calculée sur le prix total du menu.
        const discount = Number.isInteger(persons)
            && persons >= minimumPersons + 5
            ? Math.round(menuPrice * 10) / 100
            : 0;

        const total = Math.round(
            (menuPrice - discount + deliveryFee) * 100
        ) / 100;

        menuPriceElement.textContent = euro.format(menuPrice);
        deliveryPriceElement.textContent = euro.format(deliveryFee);
        discountPriceElement.textContent = '- ' + euro.format(discount);
        grandTotalElement.textContent = euro.format(total);
    }

    personsInput.addEventListener('input', updatePriceSummary);

    updatePriceSummary();
});
</script>
@endsection
