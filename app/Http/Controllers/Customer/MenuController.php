<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(private readonly MenuRepository $menuRepository) {}

    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category');
        $categories = \App\Models\Category::all();

        $menus = $this->menuRepository->filter($search, $categoryId ? (int)$categoryId : null);

        return view('customer.menu.index', compact('menus', 'categories'));
    }

    public function show(string $slug)
    {
        $menu = $this->menuRepository->findBySlug($slug);
        abort_if(! $menu, 404, 'Menu tidak ditemukan.');
        
        $relatedMenus = \App\Models\Menu::where('category_id', $menu->category_id)
            ->where('id', '!=', $menu->id)
            ->available()
            ->limit(4)
            ->get();

        return view('customer.menu.show', compact('menu', 'relatedMenus'));
    }
}
