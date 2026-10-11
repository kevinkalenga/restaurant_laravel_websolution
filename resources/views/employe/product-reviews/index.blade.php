<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des avis clients</title>

    <link href="{{ asset('admin/employe/assets/vendor/bootstrap/css/bootstrap.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset('admin/employe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
          rel="stylesheet">
    <link href="{{ asset('admin/employe/assets/css/main.css') }}"
          rel="stylesheet">

    <style>
        body {
            background: #f6f8fb;
            color: #243044;
        }

        .review-card {
            background: #fff;
            border: 1px solid #e7ebf0;
            border-radius: 14px;
            padding: 24px;
        }

        .review-table th {
            white-space: nowrap;
            color: #687386;
        }

        .review-table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3">Gestion des avis clients</h1>
            <p class="text-muted mb-0">
                Consultez et validez les avis sur les produits.
            </p>
        </div>

        <a href="{{ route('employe.dashboard') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour au dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="review-card">
        <div class="table-responsive">
            <table class="table table-hover review-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Produit</th>
                        <th>Note</th>
                        <th>Commentaire</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>

                            <td>
                                {{ $review->user->name ?? 'Client inconnu' }}
                            </td>

                            <td>
                                {{ $review->product->name ?? 'Produit inconnu' }}
                            </td>

                            <td class="text-nowrap">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"
                                       style="color: #f0ad4e"></i>
                                @endfor
                                <span class="small">{{ $review->rating }}/5</span>
                            </td>

                            <td>{{ $review->review }}</td>

                            <td>
                                @if ($review->status)
                                    <span class="badge bg-success">
                                        Approuvé
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        En attente
                                    </span>
                                @endif
                            </td>

                            <td class="text-nowrap">
                                {{ $review->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>

                            <td>
                                <form method="POST"
                                      action="{{ route('employe.product-reviews.toggle-status', $review->id) }}"
                                      onsubmit="return confirm('Confirmer la modification du statut de cet avis ?')">
                                    @csrf
                                    @method('PATCH')

                                    @if ($review->status)
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-warning">
                                            Retirer l’approbation
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="btn btn-sm btn-success">
                                            Valider
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="text-center text-muted py-4">
                                Aucun avis enregistré.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
</body>
</html>
