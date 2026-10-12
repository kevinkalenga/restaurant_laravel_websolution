
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Menus traiteur</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('admin.catering-menus.index') }}">Menus traiteur</a>
            </div>
            <div class="breadcrumb-item active">Modifier</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Modifier le menu traiteur</h4>
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

            <form action="{{ route('admin.catering-menus.update', $menu) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  novalidate>
                @csrf
                @method('PUT')

                {{-- Titre --}}
                <div class="form-group">
                    <label for="title">Titre du menu *</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="{{ old('title', $menu->title) }}"
                        required
                    >
                </div>

                {{-- Image principale --}}
                <div class="form-group">
                    <label for="image-upload">Image principale</label>

                    <input
                        type="file"
                        name="image"
                        id="image-upload"
                        class="form-control"
                        accept="image/*"
                    >

                    <div id="image-preview"
                         style="margin-top:10px;width:200px;height:200px;border:1px solid #ccc;">
                        @if ($menu->image)
                            <img
                                src="{{ asset('storage/' . $menu->image) }}"
                                alt="{{ $menu->title }}"
                                style="width:100%;height:100%;object-fit:cover;display:block;"
                            >
                        @endif
                    </div>

                    <small class="form-text text-muted">
                        Sélectionne une nouvelle image uniquement si tu souhaites remplacer l’actuelle.
                    </small>
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"
                    >{{ old('description', $menu->description) }}</textarea>
                </div>

                {{-- Prix --}}
                <div class="form-group">
                    <label for="price">Prix du menu (€) *</label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        step="0.01"
                        min="0"
                        class="form-control"
                        value="{{ old('price', $menu->price) }}"
                        required
                    >
                    <small class="form-text text-muted">
                        Prix correspondant au nombre minimum de personnes.
                    </small>
                </div>

                {{-- Minimum de personnes --}}
                <div class="form-group">
                    <label for="minimum_persons">Nombre minimum de personnes *</label>
                    <input
                        type="number"
                        name="minimum_persons"
                        id="minimum_persons"
                        min="1"
                        class="form-control"
                        value="{{ old('minimum_persons', $menu->minimum_persons) }}"
                        required
                    >
                </div>

                {{-- Stock --}}
                <div class="form-group">
                    <label for="available_stock">Stock disponible *</label>
                    <input
                        type="number"
                        name="available_stock"
                        id="available_stock"
                        min="0"
                        class="form-control"
                        value="{{ old('available_stock', $menu->available_stock) }}"
                        required
                    >
                </div>

                {{-- Thème --}}
                <div class="form-group">
                    <label for="theme">Thème *</label>
                    <select name="theme" id="theme" class="form-control" required>
                        <option value="classique" @selected(old('theme', $menu->theme) === 'classique')>
                            Classique
                        </option>
                        <option value="noel" @selected(old('theme', $menu->theme) === 'noel')>
                            Noël
                        </option>
                        <option value="paques" @selected(old('theme', $menu->theme) === 'paques')>
                            Pâques
                        </option>
                        <option value="evenement" @selected(old('theme', $menu->theme) === 'evenement')>
                            Événement
                        </option>
                    </select>
                </div>

                {{-- Régime alimentaire --}}
                <div class="form-group">
                    <label for="diet">Régime alimentaire *</label>
                    <select name="diet" id="diet" class="form-control" required>
                        <option value="classique" @selected(old('diet', $menu->diet) === 'classique')>
                            Classique
                        </option>
                        <option value="vegetarien" @selected(old('diet', $menu->diet) === 'vegetarien')>
                            Végétarien
                        </option>
                        <option value="vegan" @selected(old('diet', $menu->diet) === 'vegan')>
                            Vegan
                        </option>
                    </select>
                </div>

                {{-- Délai de commande --}}
                <div class="form-group">
                    <label for="advance_notice_hours">Délai de commande (heures) *</label>
                    <input
                        type="number"
                        name="advance_notice_hours"
                        id="advance_notice_hours"
                        min="0"
                        class="form-control"
                        value="{{ old('advance_notice_hours', $menu->advance_notice_hours) }}"
                        required
                    >
                </div>

                {{-- Conservation --}}
                <div class="form-group">
                    <label for="storage_conditions">Conditions de conservation</label>
                    <textarea
                        name="storage_conditions"
                        id="storage_conditions"
                        class="form-control"
                        rows="3"
                    >{{ old('storage_conditions', $menu->storage_conditions) }}</textarea>
                </div>

                {{-- Conditions de commande --}}
                <div class="form-group">
                    <label for="order_conditions">Conditions de commande</label>
                    <textarea
                        name="order_conditions"
                        id="order_conditions"
                        class="form-control"
                        rows="3"
                    >{{ old('order_conditions', $menu->order_conditions) }}</textarea>
                </div>

                {{-- Statut --}}
                <div class="form-group">
                    <label for="status">Statut *</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="1" @selected((string) old('status', (string) (int) $menu->status) === '1')>
                            Actif
                        </option>
                        <option value="0" @selected((string) old('status', (string) (int) $menu->status) === '0')>
                            Inactif
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Enregistrer les modifications
                </button>

                <a href="{{ route('admin.catering-menus.index') }}"
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

            if (!file) {
                return;
            }

            if (imagePreview.dataset.previewUrl) {
                URL.revokeObjectURL(imagePreview.dataset.previewUrl);
            }

            imagePreview.innerHTML = '';

            const img = document.createElement('img');
            const previewUrl = URL.createObjectURL(file);

            imagePreview.dataset.previewUrl = previewUrl;
            img.src = previewUrl;
            img.alt = 'Aperçu de la nouvelle image';
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            img.style.display = 'block';

            imagePreview.appendChild(img);
        });
    }
});
</script>
@endpush