<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion des menus') - Espace employé</title>

    <link href="{{ asset('admin/employe/assets/img/favicon.png') }}" rel="icon">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('admin/employe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/employe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/employe/assets/css/main.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Geist', sans-serif;
            background: #f5f7fa;
        }

        .dashboard-header {
            background: #fff;
            padding: 24px 0;
            margin-bottom: 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .page-card {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
        }
    </style>

    @stack('styles')
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

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('employe.dashboard') }}" class="btn btn-outline-primary">
                    <i class="bi bi-house me-1"></i> Tableau de bord
                </a>

                <a href="{{ route('employe.catering-menus.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-card-list me-1"></i> Gestion des menus
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('admin/employe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
