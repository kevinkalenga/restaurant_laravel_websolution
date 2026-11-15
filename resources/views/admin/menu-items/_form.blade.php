
<div class="form-group">
    <label for="name">Nom de l'élément *</label>
    <input
        type="text"
        name="name"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $menuItem->name ?? '') }}"
        required
    >
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="category">Catégorie *</label>
    <select name="category" id="category" class="form-control" required>
        <option value="">-- Choisir une catégorie --</option>
        <option value="entree" @selected(old('category', $menuItem->category ?? '') === 'entree')>
            Entrée
        </option>
        <option value="plat" @selected(old('category', $menuItem->category ?? '') === 'plat')>
            Plat
        </option>
        <option value="dessert" @selected(old('category', $menuItem->category ?? '') === 'dessert')>
            Dessert
        </option>
    </select>
    @error('category')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea
        name="description"
        id="description"
        class="form-control"
        rows="4"
    >{{ old('description', $menuItem->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="price">Prix indicatif (€)</label>
    <input
        type="number"
        name="price"
        id="price"
        step="0.01"
        min="0"
        class="form-control"
        value="{{ old('price', $menuItem->price ?? '') }}"
    >
</div>

{{-- Sélection des allergènes --}}
<div class="form-group mt-3">
    <label class="font-weight-bold">Allergènes</label>

    <p class="text-muted">
        Sélectionnez tous les allergènes présents dans cet élément.
    </p>

    @php
        $selectedAllergens = old(
            'allergens',
            isset($menuItem)
                ? $menuItem->allergens->pluck('id')->toArray()
                : []
        );
    @endphp

    <div class="row">
        @forelse($allergens as $allergen)
            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="allergens[]"
                        id="allergen_{{ $allergen->id }}"
                        value="{{ $allergen->id }}"
                        @checked(in_array($allergen->id, $selectedAllergens))
                    >

                    <label
                        class="form-check-label"
                        for="allergen_{{ $allergen->id }}"
                    >
                        {{ $allergen->name }}
                    </label>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-warning">
                    Aucun allergène enregistré dans la base de données.
                </p>
            </div>
        @endforelse
    </div>

    @error('allergens')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    @error('allergens.*')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input
        type="file"
        name="image"
        id="image"
        class="form-control"
        accept="image/*"
    >

    @if (!empty($menuItem->image))
        <div class="mt-3">
            <p>Image actuelle :</p>
            <img
                src="{{ asset('storage/' . $menuItem->image) }}"
                alt="{{ $menuItem->name }}"
                style="width:150px;height:120px;object-fit:cover;"
            >
        </div>
    @endif
</div>

<div class="form-group">
    <label for="status">Statut</label>
    <select name="status" id="status" class="form-control">
        <option value="1"
            @selected((string) old('status', isset($menuItem) ? (int) $menuItem->status : 1) === '1')>
            Actif
        </option>
        <option value="0"
            @selected((string) old('status', isset($menuItem) ? (int) $menuItem->status : 1) === '0')>
            Inactif
        </option>
    </select>
</div>

<button type="submit" class="btn btn-primary">
    {{ $submitLabel }}
</button>

<a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">
    Annuler
</a>
