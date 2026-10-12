
@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">
    <h2>Commander un menu traiteur</h2>

    <div class="card p-4 mt-4">
        <h4>{{ $menu->title }}</h4>
        <p>{{ $menu->description }}</p>

        <p>
            Prix de base du menu :
            <strong>{{ number_format((float) $menu->price, 2, ',', ' ') }} €</strong>
        </p>

        <p>
            Nombre minimum de personnes :
            <strong>{{ $menu->minimum_persons }}</strong>
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
                    value="{{ old('number_of_persons', $menu->minimum_persons) }}"
                    required
                >
                <small class="text-muted">
                    Minimum : {{ $menu->minimum_persons }} personnes.
                </small>
            </div>
        </div>

        <button type="submit" class="common_btn">
            Continuer la commande
        </button>
    </form>
</div>
@endsection
