
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Éléments traiteur</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Modifier : {{ $menuItem->name }}</h4>
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
                action="{{ route('admin.menu-items.update', $menuItem->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                @include('admin.menu-items._form', [
                    'menuItem' => $menuItem,
                    'submitLabel' => 'Enregistrer les modifications'
                ])
            </form>

        </div>
    </div>
</section>
@endsection
