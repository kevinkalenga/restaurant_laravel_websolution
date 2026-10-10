@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Gestion des employés</h4>

                        <a href="{{ route('admin.employees.create') }}"
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Ajouter un employé
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Adresse e-mail</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>
                                                @if ($employee->is_active)
                                                    <span class="badge badge-success">Actif</span>
                                                @else
                                                    <span class="badge badge-secondary">Désactivé</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.employees.toggle-status', $employee) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Confirmer le changement de statut de ce compte ?');">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                            class="btn btn-sm {{ $employee->is_active ? 'btn-warning' : 'btn-success' }}">
                                                        {{ $employee->is_active ? 'Désactiver' : 'Activer' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                Aucun employé enregistré pour le moment.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
