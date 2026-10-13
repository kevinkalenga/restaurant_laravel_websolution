
@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">
    <h2>Modifier ma commande traiteur</h2>

    <div class="card p-4 mt-4">
        <h4>{{ $menu->title }}</h4>
        <p>{{ $menu->description }}</p>

        <p>
            Prix du menu :
            <strong>{{ number_format((float) $menu->price, 2, ',', ' ') }} €</strong>
        </p>

        <p>
            Minimum :
            <strong>{{ $menu->minimum_persons }} personnes</strong>
        </p>

        <div class="alert alert-info mb-0">
            Le menu choisi ne peut pas être modifié.
        </div>
    </div>

    <form
        action="{{ route('catering-orders.update', $order->id) }}"
        method="POST"
        class="mt-4"
        id="catering-order-form"
    >
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name">Prénom *</label>
                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    class="form-control"
                    value="{{ old('first_name', $order->catering_first_name) }}"
                    maxlength="255"
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
                    value="{{ old('last_name', $order->catering_last_name) }}"
                    maxlength="255"
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
                    value="{{ old('email', $order->catering_email) }}"
                    maxlength="255"
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
                    value="{{ old('phone', $order->catering_phone) }}"
                    maxlength="30"
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
                    required
                >{{ old('address', $order->address) }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label for="delivery_date">Date de prestation *</label>
                <input
                    type="date"
                    id="delivery_date"
                    name="delivery_date"
                    class="form-control"
                    min="{{ now()->toDateString() }}"
                    value="{{ old('delivery_date', $order->delivery_date ? \Illuminate\Support\Carbon::parse($order->delivery_date)->format('Y-m-d') : '') }}"
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
                    value="{{ old('delivery_time', $order->delivery_time ? substr((string) $order->delivery_time, 0, 5) : '') }}"
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
                    value="{{ old('service_location', $order->service_location) }}"
                    maxlength="255"
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
                    value="{{ old('number_of_persons', $order->number_of_persons) }}"
                    required
                >
                <small class="text-muted">
                    Minimum : {{ $menu->minimum_persons }} personnes.
                    Réduction de 10 % à partir de
                    {{ (int) $menu->minimum_persons + 5 }} personnes.
                </small>
            </div>
        </div>

        <div class="card p-4 mt-3 mb-4">
            <h4>Récapitulatif estimé</h4>

            <div class="d-flex justify-content-between py-2">
                <span>Prix du menu</span>
                <strong id="menu-price"></strong>
            </div>

            <div class="d-flex justify-content-between py-2">
                <span>Livraison</span>
                <strong id="delivery-price"></strong>
            </div>

            <div class="d-flex justify-content-between py-2">
                <span>Réduction</span>
                <strong id="discount-price"></strong>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <strong>Total estimé</strong>
                <strong id="grand-total" class="fs-4"></strong>
            </div>

            <small class="text-muted mt-2">
                Les frais de livraison affichés restent provisoires.
            </small>
        </div>

        <button type="submit" class="common_btn">
            Enregistrer les modifications
        </button>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            Retour
        </a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const personsInput = document.getElementById('number_of_persons');
    const menuPrice = {{ (float) $menu->price }};
    const minimumPersons = {{ (int) $menu->minimum_persons }};
    const deliveryFee = {{ (float) $order->delivery_charge }};

    const euro = new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    });

    function updatePriceSummary() {
        const persons = Number.parseInt(personsInput.value, 10);

        const discount = Number.isInteger(persons)
            && persons >= minimumPersons + 5
            ? Math.round(menuPrice * 10) / 100
            : 0;

        const total = Math.round(
            (menuPrice - discount + deliveryFee) * 100
        ) / 100;

        document.getElementById('menu-price').textContent =
            euro.format(menuPrice);

        document.getElementById('delivery-price').textContent =
            euro.format(deliveryFee);

        document.getElementById('discount-price').textContent =
            '- ' + euro.format(discount);

        document.getElementById('grand-total').textContent =
            euro.format(total);
    }

    personsInput.addEventListener('input', updatePriceSummary);
    updatePriceSummary();
});
</script>
@endsection
