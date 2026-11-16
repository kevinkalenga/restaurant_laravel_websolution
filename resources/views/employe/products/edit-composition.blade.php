
@extends('employe.layouts.master')

@section('title', 'Modifier la composition')

@section('content')

<div class="mb-4">
    <a href="{{ route('employe.products.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left me-1"></i> Retour aux produits
    </a>

    <h2 class="h4 mb-1">Composition du produit</h2>
    <p class="text-muted mb-0">
        Produit : <strong>{{ $product->name }}</strong>
    </p>
</div>

<div class="page-card">

    <form
        action="{{ route('employe.products.composition.update', $product->id) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        @php
            $selectedMenuItems = old(
                'menu_items',
                $product->menuItems->pluck('id')->all()
            );

            $categories = [
                'entree' => 'Entrées',
                'plat' => 'Plats',
                'dessert' => 'Desserts',
            ];
        @endphp

        <p class="text-muted mb-4">
            Sélectionnez les éléments qui composent ce produit et indiquez
            la quantité souhaitée pour chacun.
        </p>

        @foreach ($categories as $category => $label)

            @php
                $items = $menuItems->where('category', $category);
            @endphp

            <div class="mb-4">
                <h5 class="mb-3">
                    <i class="bi bi-card-checklist me-2 text-primary"></i>
                    {{ $label }}
                </h5>

                @if ($items->isEmpty())
                    <p class="text-muted">
                        Aucun élément disponible dans cette catégorie.
                    </p>
                @else

                    <div class="row g-3">
                        @foreach ($items as $item)

                            @php
                                $isSelected = in_array($item->id, $selectedMenuItems);
                                $existingItem = $product->menuItems->firstWhere('id', $item->id);
                                $defaultQuantity = $existingItem
                                    ? $existingItem->pivot->quantity
                                    : 1;
                            @endphp

                            <div class="col-12 col-md-6">
                                <div class="border rounded-3 p-3 h-100">

                                    <div class="form-check mb-3">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="menu_items[]"
                                            value="{{ $item->id }}"
                                            id="menu_item_{{ $item->id }}"
                                            {{ in_array($item->id, old('menu_items', $product->menuItems->pluck('id')->all())) ? 'checked' : '' }}
                                        >

                                        <label
                                            class="form-check-label fw-semibold"
                                            for="menu_item_{{ $item->id }}"
                                        >
                                            {{ $item->name }}
                                        </label>
                                    </div>

                                    @if ($item->image)
                                        <img
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->name }}"
                                            class="img-fluid rounded mb-3"
                                            style="height: 120px; width: 100%; object-fit: cover;"
                                        >
                                    @endif

                                    @if ($item->description)
                                        <p class="text-muted small mb-2">
                                            {{ $item->description }}
                                        </p>
                                    @endif

                                    <p class="small mb-2">
                                        <strong>Prix :</strong>
                                        {{ number_format($item->price, 2, ',', ' ') }} €
                                    </p>

                                    <label
                                        for="quantity_{{ $item->id }}"
                                        class="form-label small"
                                    >
                                        Quantité
                                    </label>

                                    <input
                                        type="number"
                                        name="quantities[{{ $item->id }}]"
                                        id="quantity_{{ $item->id }}"
                                        class="form-control form-control-sm"
                                        min="1"
                                        value="{{ old('quantities.' . $item->id, $defaultQuantity) }}"
                                    >

                                </div>
                            </div>

                        @endforeach
                    </div>

                @endif
            </div>

            @if (!$loop->last)
                <hr class="my-4">
            @endif

        @endforeach

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('employe.products.index') }}" class="btn btn-outline-secondary">
                Annuler
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i>
                Enregistrer la composition
            </button>
        </div>

    </form>

</div>

@endsection
