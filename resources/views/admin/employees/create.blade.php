@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Créer un compte employé</h4>
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

                        <form action="{{ route('admin.employees.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nom complet</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    value="{{ old('name') }}"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="email">Adresse e-mail (identifiant)</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="password">Mot de passe provisoire</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    minlength="10"
                                    autocomplete="new-password"
                                    required
                                >
                                <small class="form-text text-muted">
                                    Au moins 10 caractères, avec majuscule, minuscule, chiffre et caractère spécial.
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    minlength="10"
                                    autocomplete="new-password"
                                    required
                                >
                            </div>

                            <div class="alert alert-info">
                                Le mot de passe ne sera pas envoyé par e-mail.
                                L’employé devra contacter l’administrateur pour l’obtenir.
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Créer le compte
                            </button>

                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                                Retour à la liste
                            </a>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
