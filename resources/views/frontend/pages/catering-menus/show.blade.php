
@extends('frontend.layouts.master')

@section('content')

<section class="fp__breadcrumb"
    style="background: url({{ asset(config('settings.breadcrumb')) }});">
    <div class="fp__breadcrumb_overlay">
        <div class="container">
            <div class="fp__breadcrumb_text">
                <h1>{{ $menu->title }}</h1>
                <ul>
                    <li><a href="{{ url('/') }}">Accueil</a></li>
                    <li>
                        <a href="{{ route('catering-menus.index') }}">
                            Menus traiteur
                        </a>
                    </li>
                    <li>{{ $menu->title }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="mt_120 xs_mt_90 mb_100 xs_mb_70">
    <div class="container">

        <div class="row">
            <div class="col-lg-6 mb-4">
                @if($menu->image)
                    <img
                        src="{{ asset('storage/' . $menu->image) }}"
                        alt="{{ $menu->title }}"
                        class="img-fluid w-100 rounded">
                @else
                    <div class="bg-light text-center p-5">
                        <i class="fas fa-utensils fa-4x"></i>
                    </div>
                @endif

                @if($menu->galleries->isNotEmpty())
                    <div class="row mt-3">
                        @foreach($menu->galleries as $gallery)
                            <div class="col-4 mb-3">
                                <img
                                    src="{{ asset('storage/' . $gallery->image) }}"
                                    alt="Photo du menu {{ $menu->title }}"
                                    class="img-fluid rounded"
                                    loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-6">
                <h2>{{ $menu->title }}</h2>

                <p class="mt-3">
                    {{ $menu->description }}
                </p>

                <div class="my-4">
                    <h3>{{ currencyPosition($menu->price) }}</h3>
                    <p class="text-muted">
                        Prix du menu pour le minimum de
                        {{ $menu->minimum_persons }} personne(s).
                    </p>
                </div>

                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Thème :</strong>
                        {{ ucfirst($menu->theme) }}
                    </li>
                    <li class="mb-2">
                        <strong>Régime :</strong>
                        {{ ucfirst($menu->diet) }}
                    </li>
                    <li class="mb-2">
                        <strong>Minimum de personnes :</strong>
                        {{ $menu->minimum_persons }}
                    </li>
                    <li class="mb-2">
                        <strong>Délai de commande :</strong>
                        {{ $menu->advance_notice_hours }} heure(s) à l'avance
                    </li>
                    <li class="mb-2">
                        <strong>Disponibilité :</strong>
                        {{ $menu->available_stock }} commande(s)
                    </li>
                </ul>

                @if($menu->storage_conditions)
                    <div class="mt-4">
                        <h5>Conditions de conservation</h5>
                        <p>{{ $menu->storage_conditions }}</p>
                    </div>
                @endif

                @if($menu->order_conditions)
                    <div class="mt-3">
                        <h5>Conditions de commande</h5>
                        <p>{{ $menu->order_conditions }}</p>
                    </div>
                @endif

                
                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a href="{{ route('catering-menus.index') }}"
                        class="common_btn">
                        Retour aux menus
                    </a>

                    @auth
                        @if($menu->status && $menu->available_stock > 0)
                            <a href="{{ route('catering-orders.create', $menu->slug) }}"
                                class="common_btn">
                                Commander ce menu
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="common_btn">
                            Connectez-vous pour commander
                        </a>
                    @endauth
                </div>

            </div>
        </div>

        <hr class="my-5">

        <div class="row">
            <div class="col-12">
                <h3 class="mb-4">Composition du menu</h3>
            </div>

            @php
                $dishTypes = [
                    'entree' => 'Entrées',
                    'plat' => 'Plats',
                    'dessert' => 'Desserts',
                ];
            @endphp

            @foreach($dishTypes as $type => $label)
                @php
                    $dishes = $menu->products->filter(function ($product) use ($type) {
                        return $product->pivot->dish_type === $type;
                    });
                @endphp

                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="mb-3">{{ $label }}</h4>

                            @forelse($dishes as $dish)
                                <div class="border-bottom pb-3 mb-3">
                                    <h5>{{ $dish->name }}</h5>

                                    @if($dish->short_description)
                                        <p>{{ $dish->short_description }}</p>
                                    @endif

                                    @if($dish->pivot->quantity > 1)
                                        <p class="text-muted">
                                            Quantité prévue :
                                            {{ $dish->pivot->quantity }}
                                        </p>
                                    @endif

                                    @if($dish->allergens->isNotEmpty())
                                        <p class="mb-1">
                                            <strong>Allergènes :</strong>
                                        </p>
                                        <ul class="mb-0">
                                            @foreach($dish->allergens as $allergen)
                                                <li>
                                                    {{ $allergen->name }}
                                                    @if($allergen->description)
                                                        — {{ $allergen->description }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted mb-0">
                                            Aucun allergène renseigné.
                                        </p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-muted">
                                    Aucun élément renseigné dans cette catégorie.
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
