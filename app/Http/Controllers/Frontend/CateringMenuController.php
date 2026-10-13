<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\CateringOrderReview;

class CateringMenuController extends Controller
{
    /**
     * Liste publique des menus traiteur et filtres.
     */
    public function index(Request $request)
    {
        $menus = Menu::query()
            ->where('status', 1)
            ->with(['galleries', 'products']);

        if ($request->filled('theme')) {
            $menus->where('theme', $request->theme);
        }

        if ($request->filled('diet')) {
            $menus->where('diet', $request->diet);
        }

        if ($request->filled('min_persons')) {
            $menus->where(
                'minimum_persons',
                '<=',
                (int) $request->min_persons
            );
        }

        if ($request->filled('max_price')) {
            $menus->where('price', '<=', (float) $request->max_price);
        }

        if ($request->filled('min_price')) {
            $menus->where('price', '>=', (float) $request->min_price);
        }

        $menus = $menus->latest()->paginate(9)->withQueryString();

        return view('frontend.pages.catering-menus.index', compact('menus'));
    }

    /**
     * Détail public d'un menu traiteur.
     */
    
     
    public function show(string $slug)
    {
        $menu = Menu::query()
            ->where('status', 1)
            ->where('slug', $slug)
            ->with(['galleries', 'products', 'products.allergens'])
            ->firstOrFail();

        $reviews = CateringOrderReview::with('user')
            ->where('status', 1)
            ->whereHas('order', function ($query) use ($menu) {
                $query->where('catering_menu_id', $menu->id);
            })
            ->latest()
            ->get();

        return view(
            'frontend.pages.catering-menus.show',
            compact('menu', 'reviews')
        );
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * Réponse JSON destinée aux filtres AJAX.
     */
    public function filter(Request $request)
    {
        $menus = Menu::query()
            ->where('status', 1)
            ->with(['galleries', 'products']);

        if ($request->filled('theme')) {
            $menus->where('theme', $request->theme);
        }

        if ($request->filled('diet')) {
            $menus->where('diet', $request->diet);
        }

        if ($request->filled('min_persons')) {
            $menus->where(
                'minimum_persons',
                '<=',
                (int) $request->min_persons
            );
        }

        if ($request->filled('min_price')) {
            $menus->where('price', '>=', (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $menus->where('price', '<=', (float) $request->max_price);
        }

        return response()->json([
            'menus' => $menus->latest()->get()->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'title' => $menu->title,
                    'slug' => $menu->slug,
                    'description' => $menu->description,
                    'image' => $menu->image
                        ? asset('storage/' . $menu->image)
                        : null,
                    'price' => (float) $menu->price,
                    'minimum_persons' => $menu->minimum_persons,
                    'theme' => $menu->theme,
                    'diet' => $menu->diet,
                    'available_stock' => $menu->available_stock,
                    'url' => route('catering-menus.show', $menu->slug),
                ];
            }),
        ]);
    }
}
