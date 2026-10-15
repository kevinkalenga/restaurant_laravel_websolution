
@extends('employe.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Menus traiteur</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h4>Tous les menus traiteur</h4>

            <div class="card-header-action">
                <a href="{{ route('employe.catering-menus.create') }}"
                   class="btn btn-primary">
                    Ajouter un menu
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Thème</th>
                            <th>Régime</th>
                            <th>Prix</th>
                            <th>Minimum personnes</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($menus as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>

                                <td>
                                    @if ($menu->image)
                                        <img
                                            src="{{ asset('storage/' . $menu->image) }}"
                                            alt="{{ $menu->title }}"
                                            width="65"
                                            height="50"
                                            style="object-fit: cover; border-radius: 4px;"
                                        >
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>{{ $menu->title }}</td>

                                <td>
                                    @switch($menu->theme)
                                        @case('noel')
                                            Noël
                                            @break
                                        @case('paques')
                                            Pâques
                                            @break
                                        @case('evenement')
                                            Événement
                                            @break
                                        @default
                                            Classique
                                    @endswitch
                                </td>

                                <td>
                                    @switch($menu->diet)
                                        @case('vegetarien')
                                            Végétarien
                                            @break
                                        @case('vegan')
                                            Vegan
                                            @break
                                        @default
                                            Classique
                                    @endswitch
                                </td>

                                <td>
                                    {{ number_format((float) $menu->price, 2, ',', ' ') }} €
                                </td>

                                <td>{{ $menu->minimum_persons }}</td>

                                <td>{{ $menu->available_stock }}</td>

                                <td>
                                    @if ($menu->status)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>

                                <td>
                                    <a
                                        href="{{ route('employe.catering-menus.edit', $menu) }}"
                                        class="btn btn-warning btn-sm"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>

                                    <form
                                        action="{{ route('employe.catering-menus.destroy', $menu) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce menu ?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Supprimer"
                                        >
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    Aucun menu traiteur enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
