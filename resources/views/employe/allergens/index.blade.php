
@extends('employe.layouts.master')

@section('title', 'Gestion des allergènes')

@section('content')
<section class="section">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="h4 mb-1">Gestion des allergènes</h2>
            <p class="text-muted mb-0">
                Consultez les allergènes enregistrés dans la base de données.
            </p>
        </div>

        <a href="{{ route('employe.allergens.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Ajouter un allergène
        </a>
    </div>

    <div class="page-card">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom de l'allergène</th>
                        <th>Description</th>
                        <th>Date de création</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($allergens as $allergen)
                        <tr>
                            <td>{{ $allergen->id }}</td>

                            <td class="fw-semibold">
                                {{ $allergen->name }}
                            </td>

                            <td>
                                {{ $allergen->description ?: 'Aucune description' }}
                            </td>

                            <td>
                                {{ $allergen->created_at?->format('d/m/Y') ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Aucun allergène enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $allergens->links() }}
        </div>

    </div>
</section>
@endsection
