
@extends('frontend.layouts.master')

@section('content')

<section class="fp__breadcrumb"
    style="background: url({{ asset(config('settings.breadcrumb')) }});">
    <div class="fp__breadcrumb_overlay">
        <div class="container">
            <div class="fp__breadcrumb_text">
                <h1>Nos menus traiteur</h1>
                <ul>
                    <li><a href="{{ url('/') }}">Accueil</a></li>
                    <li>
                        <a href="{{ route('catering-menus.index') }}">Menus traiteur</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="fp__search_menu mt_120 xs_mt_90 mb_100 xs_mb_70">
    <div class="container">

        <div class="text-center mb-5">
            <h2>Nos menus pour vos événements</h2>
            <p>Découvrez nos menus et choisissez celui qui vous convient.</p>
        </div>

        {{-- Filtres --}}
        <div class="card mb-5">
            <div class="card-body p-4">

                <form id="catering-filter-form" class="fp__search_menu_form">
                    <div class="row">

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="theme">Thème</label>
                            <select class="form-control" id="theme" name="theme">
                                <option value="">Tous les thèmes</option>
                                <option value="classique">Classique</option>
                                <option value="noel">Noël</option>
                                <option value="paques">Pâques</option>
                                <option value="evenement">Événement</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="diet">Régime alimentaire</label>
                            <select class="form-control" id="diet" name="diet">
                                <option value="">Tous les régimes</option>
                                <option value="classique">Classique</option>
                                <option value="vegetarien">Végétarien</option>
                                <option value="vegan">Végan</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label for="min_price">Prix minimum (€)</label>
                            <input
                                class="form-control"
                                type="number"
                                id="min_price"
                                name="min_price"
                                min="0"
                                step="0.01"
                                placeholder="0">
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label for="max_price">Prix maximum (€)</label>
                            <input
                                class="form-control"
                                type="number"
                                id="max_price"
                                name="max_price"
                                min="0"
                                step="0.01"
                                placeholder="Sans limite">
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label for="min_persons">Nombre de personnes</label>
                            <input
                                class="form-control"
                                type="number"
                                id="min_persons"
                                name="min_persons"
                                min="1"
                                placeholder="Ex. 10">
                        </div>

                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="common_btn">
                            Filtrer
                        </button>

                        <button
                            type="button"
                            class="common_btn mt-2"
                            id="reset-filters">
                            Réinitialiser
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <div id="filter-message" class="mb-3" role="status"></div>

        {{-- Liste des menus --}}
        <div class="row" id="catering-menu-list">

            @forelse($menus as $menu)
                <div class="col-xl-4 col-sm-6 col-lg-4 mb-4">
                    <div class="fp__menu_item h-100">

                        <div class="fp__menu_item_img">
                            @if($menu->image)
                                <img
                                    src="{{ asset('storage/' . $menu->image) }}"
                                    alt="{{ $menu->title }}"
                                    class="img-fluid w-100"
                                    loading="lazy">
                            @else
                                <div class="text-center p-5 bg-light">
                                    <i class="fas fa-utensils fa-3x"></i>
                                </div>
                            @endif

                            <span class="category">
                                {{ ucfirst($menu->theme) }}
                            </span>
                        </div>

                        <div class="fp__menu_item_text">

                            <a
                                class="title"
                                href="{{ route('catering-menus.show', $menu->slug) }}">
                                {{ $menu->title }}
                            </a>

                            <p>
                                {{ \Illuminate\Support\Str::limit($menu->description, 120) }}
                            </p>

                            <h5 class="price">
                                {{ currencyPosition($menu->price) }}
                            </h5>

                            <p>
                                <i class="fas fa-users"></i>
                                Minimum : {{ $menu->minimum_persons }} personne(s)
                            </p>

                            <p>
                                <i class="fas fa-leaf"></i>
                                Régime : {{ ucfirst($menu->diet) }}
                            </p>

                            <a
                                class="common_btn"
                                href="{{ route('catering-menus.show', $menu->slug) }}">
                                Découvrir le menu
                            </a>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Aucun menu traiteur disponible pour le moment.</p>
                </div>
            @endforelse

        </div>

        <div id="catering-pagination" class="fp__pagination mt_60">
            @if($menus->hasPages())
                {{ $menus->links() }}
            @endif
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('catering-filter-form');
    const list = document.getElementById('catering-menu-list');
    const message = document.getElementById('filter-message');
    const pagination = document.getElementById('catering-pagination');
    const filterUrl = @json(route('catering-menus.filter'));

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function renderMenus(menus) {
        if (!menus.length) {
            list.innerHTML = `
                <div class="col-12 text-center">
                    <p>Aucun menu ne correspond à vos critères.</p>
                </div>`;
            return;
        }

        list.innerHTML = menus.map(function (menu) {
            const image = menu.image
                ? `<img src="${escapeHtml(menu.image)}"
                        alt="${escapeHtml(menu.title)}"
                        class="img-fluid w-100"
                        loading="lazy">`
                : `<div class="text-center p-5 bg-light">
                        <i class="fas fa-utensils fa-3x"></i>
                   </div>`;

            const description = escapeHtml(menu.description || '');
            const shortDescription = description.length > 120
                ? description.substring(0, 120) + '…'
                : description;

            const price = new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'EUR'
            }).format(menu.price);

            return `
                <div class="col-xl-4 col-sm-6 col-lg-4 mb-4">
                    <div class="fp__menu_item h-100">
                        <div class="fp__menu_item_img">
                            ${image}
                            <span class="category">
                                ${escapeHtml(menu.theme)}
                            </span>
                        </div>

                        <div class="fp__menu_item_text">
                            <a class="title" href="${escapeHtml(menu.url)}">
                                ${escapeHtml(menu.title)}
                            </a>

                            <p>${shortDescription}</p>

                            <h5 class="price">${price}</h5>

                            <p>
                                <i class="fas fa-users"></i>
                                Minimum : ${escapeHtml(menu.minimum_persons)} personne(s)
                            </p>

                            <p>
                                <i class="fas fa-leaf"></i>
                                Régime : ${escapeHtml(menu.diet)}
                            </p>

                            <a class="common_btn" href="${escapeHtml(menu.url)}">
                                Découvrir le menu
                            </a>
                        </div>
                    </div>
                </div>`;
        }).join('');
    }

    async function applyFilters() {
        const params = new URLSearchParams(new FormData(form));

        for (const [key, value] of [...params.entries()]) {
            if (!value.trim()) {
                params.delete(key);
            }
        }

        message.textContent = 'Recherche en cours…';

        try {
            const response = await fetch(
                `${filterUrl}?${params.toString()}`,
                {
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            if (!response.ok) {
                throw new Error('La recherche a échoué.');
            }

            const data = await response.json();

            renderMenus(data.menus);
            pagination.innerHTML = '';
            message.textContent = `${data.menus.length} menu(s) trouvé(s).`;

        } catch (error) {
            message.textContent =
                'Impossible de charger les menus. Réessaie dans quelques instants.';
        }
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        applyFilters();
    });

    document.getElementById('reset-filters').addEventListener('click', function () {
        form.reset();
        applyFilters();
    });

    form.querySelectorAll('select, input').forEach(function (field) {
        field.addEventListener('change', applyFilters);
    });
});
</script>
@endpush
