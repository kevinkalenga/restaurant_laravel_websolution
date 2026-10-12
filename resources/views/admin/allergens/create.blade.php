@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Ajouter un allergène</h1>
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Informations de l'allergène</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.allergens.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nom de l'allergène *</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
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
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Enregistrer
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
