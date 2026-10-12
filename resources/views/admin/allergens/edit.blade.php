@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Modifier un allergène</h1>
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ $allergen->name }}</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.allergens.update', $allergen) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nom de l'allergène *</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $allergen->name) }}"
                            required
                            maxlength="255"
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="4"
                        >{{ old('description', $allergen->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Enregistrer les modifications
                    </button>

                    <a href="{{ route('admin.allergens.index') }}"
                       class="btn btn-secondary">
                        Annuler
                    </a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
