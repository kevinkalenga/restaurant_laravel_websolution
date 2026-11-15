
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Éléments traiteur</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Ajouter un élément traiteur</h4>
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

            <form
                action="{{ route('admin.menu-items.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                @include('admin.menu-items._form', [
                    'submitLabel' => 'Enregistrer l’élément'
                ])
            </form>

        </div>
    </div>
</section>
@endsection
