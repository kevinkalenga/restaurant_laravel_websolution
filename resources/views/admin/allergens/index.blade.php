@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gestion des allergènes</h1>

        <div class="section-header-button">
            <a href="{{ route('admin.allergens.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un allergène
            </a>
        </div>
    </div>

    <div class="section-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h4>Liste des allergènes</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Plats associés</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($allergens as $allergen)
                                <tr>
                                    <td>{{ $allergen->name }}</td>
                                    <td>{{ $allergen->description ?: '—' }}</td>
                                    <td>{{ $allergen->products_count }}</td>
                                    <td>
                                        <a href="{{ route('admin.allergens.edit', $allergen) }}"
                                           class="btn btn-warning btn-sm">
                                            Modifier
                                        </a>

                                        <form action="{{ route('admin.allergens.destroy', $allergen) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Supprimer cet allergène ?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Aucun allergène enregistré.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $allergens->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
