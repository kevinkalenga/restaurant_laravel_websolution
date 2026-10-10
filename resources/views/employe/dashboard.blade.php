<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord employé - Vite & Gourmand</title>
    <meta name="description" content="Espace employé de Vite & Gourmand">

    <link href="{{ asset('admin/employe/assets/img/favicon.png') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('admin/employe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/employe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/employe/assets/css/main.css') }}" rel="stylesheet">

    <style>
        body {
            background: #f6f8fb;
            font-family: 'Geist', sans-serif;
            color: #243044;
        }

        .dashboard-header {
            background: #fff;
            padding: 22px 0;
            border-bottom: 1px solid #e7ebf0;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e7ebf0;
            border-radius: 14px;
            padding: 22px;
            height: 100%;
        }

        .stat-card .stat-number {
            font-size: 30px;
            font-weight: 700;
            margin: 12px 0 4px;
        }

        .stat-card .stat-label {
            color: #6b7280;
            font-size: 14px;
        }

        .section-card {
            background: #fff;
            border: 1px solid #e7ebf0;
            border-radius: 14px;
            padding: 24px;
        }

        .table th {
            color: #687386;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending { background: #fff4d6; color: #946200; }
        .status-in_process { background: #dceeff; color: #175ea8; }
        .status-delivered { background: #dff7e8; color: #187342; }
        .status-declined, .status-cancelled { background: #ffe3e3; color: #a12a2a; }
        .status-default { background: #edf0f4; color: #4b5563; }
    </style>
</head>

<body>

    <header class="dashboard-header">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1">Espace employé</h1>
                <p class="text-muted mb-0">
                    Bienvenue, {{ auth()->user()->name }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </header>

    <main class="container pb-5">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <h2 class="h4">Vue d'ensemble</h2>
            <p class="text-muted">Suivi des commandes du restaurant.</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="text-muted"><i class="bi bi-receipt me-2"></i>Total des commandes</div>
                    <div class="stat-number">{{ $totalOrders }}</div>
                    <div class="stat-label">Toutes les commandes</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="text-muted"><i class="bi bi-hourglass-split me-2"></i>En attente</div>
                    <div class="stat-number">{{ $pendingOrders }}</div>
                    <div class="stat-label">À traiter</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="text-muted"><i class="bi bi-gear me-2"></i>En cours</div>
                    <div class="stat-number">{{ $inProcessOrders }}</div>
                    <div class="stat-label">En cours de préparation</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="text-muted"><i class="bi bi-check-circle me-2"></i>Livrées</div>
                    <div class="stat-number">{{ $deliveredOrders }}</div>
                    <div class="stat-label">Commandes livrées</div>
                </div>
            </div>
        </div>

        <section class="section-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h2 class="h5 mb-1">Commandes récentes</h2>
                    <p class="text-muted mb-0">Les 10 dernières commandes enregistrées.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Client</th>
                            <th>Articles</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Vue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td>
                                    {{ $order->invoice_id ?: 'Commande #' . $order->id }}
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $order->user?->name ?? 'Client inconnu' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $order->user?->email ?? '' }}
                                    </div>
                                    @if ($order->user?->phone)
                                        <div class="text-muted small">
                                            {{ $order->user->phone }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @forelse ($order->orderItems as $item)
                                        <div>
                                            {{ $item->product_name }}
                                            <span class="text-muted">× {{ $item->qty }}</span>
                                        </div>
                                    @empty
                                        <span class="text-muted">Aucun article</span>
                                    @endforelse
                                </td>

                                <td>{{ $order->product_qty ?? $order->orderItems->sum('qty') }}</td>

                                <td class="fw-semibold">
                                    {{ number_format((float) $order->grand_total, 2, ',', ' ') }}
                                    {{ $order->currency_name }}
                                </td>

                                <td>
                                    @php
                                        $statusLabels = [
                                            'pending' => 'En attente',
                                            'in_process' => 'En cours',
                                            'delivered' => 'Livrée',
                                            'declined' => 'Refusée',
                                            'cancelled' => 'Annulée',
                                        ];

                                        $status = $order->order_status;
                                    @endphp

                                    <span class="status status-{{ in_array($status, ['pending', 'in_process', 'delivered', 'declined', 'cancelled']) ? $status : 'default' }}">
                                        {{ $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status ?? 'inconnu')) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $order->created_at?->format('d/m/Y H:i') ?? '—' }}
                                </td>

                                <td>
                                    <a href="{{ route('employe.orders.show', $order->id) }}">
                                        Voir le détail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Aucune commande pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <script src="{{ asset('admin/employe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
