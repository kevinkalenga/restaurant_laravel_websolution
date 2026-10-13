
@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">
    <h2>Laisser un avis sur votre commande traiteur</h2>

    <p>Commande : #{{ $order->invoice_id }}</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('catering-orders.review.store', $order->id) }}">
        @csrf

        <div class="mb-3">
            <label for="rating" class="form-label">Votre note (1 à 5 étoiles)</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">Choisir une note</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} étoile(s)
                    </option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="review" class="form-label">Votre commentaire</label>
            <textarea name="review" id="review" class="form-control"
                      rows="5" maxlength="1000" required>{{ old('review') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer mon avis</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
