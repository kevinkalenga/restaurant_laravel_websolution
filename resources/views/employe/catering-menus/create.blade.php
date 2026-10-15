
@extends('employe.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Menus traiteur</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('employe.catering-menus.index') }}">Menus traiteur</a>
            </div>
            <div class="breadcrumb-item active">Créer</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Créer un menu traiteur</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employe.catering-menus.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  novalidate>
                @csrf

                <div class="form-group">
                    <label for="title">Titre du menu *</label>
                    <input type="text" name="title" id="title"
                           class="form-control"
                           value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="image">Image principale</label>
                    <input type="file" name="image" id="image-upload"
                           class="form-control" accept="image/*">
                    <div id="image-preview"
                         style="margin-top:10px;width:200px;height:200px;border:1px solid #ccc;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description"
                              class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="price">Prix du menu (€) *</label>
                    <input type="number" name="price" id="price"
                           step="0.01" min="0"
                           class="form-control"
                           value="{{ old('price') }}" required>
                    <small class="form-text text-muted">
                        Prix correspondant au nombre minimum de personnes.
                    </small>
                </div>

                <div class="form-group">
                    <label for="minimum_persons">Nombre minimum de personnes *</label>
                    <input type="number" name="minimum_persons" id="minimum_persons"
                           min="1" class="form-control"
                           value="{{ old('minimum_persons', 1) }}" required>
                </div>

                <div class="form-group">
                    <label for="available_stock">Stock disponible *</label>
                    <input type="number" name="available_stock" id="available_stock"
                           min="0" class="form-control"
                           value="{{ old('available_stock', 0) }}" required>
                </div>

                <div class="form-group">
                    <label for="theme">Thème *</label>
                    <select name="theme" id="theme" class="form-control" required>
                        <option value="classique" @selected(old('theme', 'classique') === 'classique')>Classique</option>
                        <option value="noel" @selected(old('theme') === 'noel')>Noël</option>
                        <option value="paques" @selected(old('theme') === 'paques')>Pâques</option>
                        <option value="evenement" @selected(old('theme') === 'evenement')>Événement</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="diet">Régime alimentaire *</label>
                    <select name="diet" id="diet" class="form-control" required>
                        <option value="classique" @selected(old('diet', 'classique') === 'classique')>Classique</option>
                        <option value="vegetarien" @selected(old('diet') === 'vegetarien')>Végétarien</option>
                        <option value="vegan" @selected(old('diet') === 'vegan')>Vegan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="advance_notice_hours">Délai de commande en heures *</label>
                    <input type="number" name="advance_notice_hours"
                           id="advance_notice_hours" min="0"
                           class="form-control"
                           value="{{ old('advance_notice_hours', 24) }}" required>
                </div>

                <div class="form-group">
                    <label for="storage_conditions">Conditions de conservation</label>
                    <textarea name="storage_conditions" id="storage_conditions"
                              class="form-control" rows="3">{{ old('storage_conditions') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="order_conditions">Conditions de commande</label>
                    <textarea name="order_conditions" id="order_conditions"
                              class="form-control" rows="3">{{ old('order_conditions') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Statut</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" @selected((string) old('status', '1') === '1')>Actif</option>
                        <option value="0" @selected((string) old('status', '1') === '0')>Inactif</option>
                    </select>
                </div>

                
                <hr>

                <h4 class="mb-3">Composition du menu</h4>
                <p class="text-muted">
                    Sélectionne les produits qui composeront ce menu, puis précise leur catégorie et leur quantité.
                </p>

                @if ($products->isEmpty())
                    <div class="alert alert-warning">
                        Aucun produit disponible. Crée d'abord des produits dans la rubrique Products.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sélection</th>
                                    <th>Produit</th>
                                    <th>Prix du produit</th>
                                    <th>Catégorie dans le menu</th>
                                    <th>Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <input
                                                type="checkbox"
                                                name="products[{{ $product->id }}][selected]"
                                                value="1"
                                                {{ old("products.{$product->id}.selected") ? 'checked' : '' }}
                                            >
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format((float) $product->price, 2, ',', ' ') }} €</td>
                                        <td>
                                            <select
                                                name="products[{{ $product->id }}][dish_type]"
                                                class="form-control"
                                            >
                                                <option value="entree"
                                                    @selected(old("products.{$product->id}.dish_type") === 'entree')>
                                                    Entrée
                                                </option>
                                                <option value="plat"
                                                    @selected(old("products.{$product->id}.dish_type", 'plat') === 'plat')>
                                                    Plat
                                                </option>
                                                <option value="dessert"
                                                    @selected(old("products.{$product->id}.dish_type") === 'dessert')>
                                                    Dessert
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input
                                                type="number"
                                                name="products[{{ $product->id }}][quantity]"
                                                class="form-control"
                                                min="1"
                                                value="{{ old("products.{$product->id}.quantity", 1) }}"
                                            >
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">
                    Créer le menu
                </button>

                <a href="{{ route('employe.catering-menus.index') }}"
                   class="btn btn-secondary">
                    Annuler
                </a>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageUpload = document.getElementById('image-upload');
    const imagePreview = document.getElementById('image-preview');

    if (imageUpload && imagePreview) {
        imageUpload.addEventListener('change', function () {
            const file = this.files[0];

            imagePreview.innerHTML = '';

            if (file) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.display = 'block';
                imagePreview.appendChild(img);
            }
        });
    }
});
</script>
@endpush
