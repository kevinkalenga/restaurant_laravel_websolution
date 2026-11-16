
@extends('employe.layouts.master')

@section('title', 'Gestion des produits')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h2 class="h4 mb-1">Gestion des produits</h2>
        <p class="text-muted mb-0">
            Gérez la composition des produits affichés sur la page d'accueil.
        </p>
    </div>
</div>

<div class="page-card">

    @if ($products->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-box-seam display-4 text-muted"></i>
            <h5 class="mt-3">Aucun produit disponible</h5>
            <p class="text-muted mb-0">
                Aucun produit n'est actuellement affiché sur la page d'accueil.
            </p>
        </div>
    @else

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Composition</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                @if ($product->thumb_image)
                                    <img
                                        src="{{ asset($product->thumb_image) }}"
                                        alt="{{ $product->name }}"
                                        width="65"
                                        height="55"
                                        style="object-fit: cover; border-radius: 8px;"
                                    >
                                @else
                                    <span class="text-muted">Aucune image</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>

                            <td>
                                {{ number_format($product->price, 2, ',', ' ') }} €
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $product->menuItems()->count() }} élément(s)
                                </span>
                            </td>

                            <td class="text-end">
                                <a
                                    href="{{ route('employe.products.composition.edit', $product->id) }}"
                                    class="btn btn-sm btn-primary"
                                >
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Modifier la composition
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $products->links() }}
        </div>

    @endif

</div>

@endsection
