
@extends('admin.layouts.master')

@section('content')
<section class="section">

    <div class="section-header">
        <h1>Éléments traiteur</h1>

        <div class="section-header-breadcrumb">
            <a href="{{ route('admin.menu-items.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un élément
            </a>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Liste des éléments traiteur</h4>
        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($menuItems as $menuItem)
                            <tr>
                                <td>
                                    @if ($menuItem->image)
                                        <img
                                            src="{{ asset('storage/' . $menuItem->image) }}"
                                            alt="{{ $menuItem->name }}"
                                            width="65"
                                            height="55"
                                            style="object-fit:cover;"
                                        >
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>{{ $menuItem->name }}</td>

                                <td>
                                    @switch($menuItem->category)
                                        @case('entree')
                                            Entrée
                                            @break
                                        @case('plat')
                                            Plat
                                            @break
                                        @case('dessert')
                                            Dessert
                                            @break
                                    @endswitch
                                </td>

                                <td>
                                    {{ $menuItem->price !== null
                                        ? number_format((float) $menuItem->price, 2, ',', ' ') . ' €'
                                        : '—' }}
                                </td>

                                <td>
                                    @if ($menuItem->status)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-secondary">Inactif</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.menu-items.edit', $menuItem->id) }}"
                                       class="btn btn-warning btn-sm">
                                        Modifier
                                    </a>

                                    <form
                                        action="{{ route('admin.menu-items.destroy', $menuItem->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer cet élément traiteur ?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Aucun élément traiteur enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $menuItems->links() }}

        </div>
    </div>
</section>
@endsection
