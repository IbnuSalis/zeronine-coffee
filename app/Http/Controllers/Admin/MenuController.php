<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->status) {
            $query->where('is_available', $request->status === 'available');
        }

        $menus = $query->orderBy('sort_order')->orderBy('name')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.menus.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'stock'            => 'required|integer|min:0',
            'preparation_time' => 'nullable|integer|min:0',
            'calories'         => 'nullable|numeric|min:0',
            'is_available'     => 'boolean',
            'is_featured'      => 'boolean',
            'is_new'           => 'boolean',
            'is_best_seller'   => 'boolean',
            'sort_order'       => 'nullable|integer',
            'image'            => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_available']   = $request->boolean('is_available');
        $validated['is_featured']    = $request->boolean('is_featured');
        $validated['is_new']         = $request->boolean('is_new');
        $validated['is_best_seller'] = $request->boolean('is_best_seller');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'stock'            => 'required|integer|min:0',
            'preparation_time' => 'nullable|integer|min:0',
            'calories'         => 'nullable|numeric|min:0',
            'is_available'     => 'boolean',
            'is_featured'      => 'boolean',
            'is_new'           => 'boolean',
            'is_best_seller'   => 'boolean',
            'sort_order'       => 'nullable|integer',
            'image'            => 'nullable|image|max:2048',
        ]);

        $validated['is_available']   = $request->boolean('is_available');
        $validated['is_featured']    = $request->boolean('is_featured');
        $validated['is_new']         = $request->boolean('is_new');
        $validated['is_best_seller'] = $request->boolean('is_best_seller');

        if ($request->hasFile('image')) {
            if ($menu->image) Storage::disk('public')->delete($menu->image);
            $validated['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) Storage::disk('public')->delete($menu->image);
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    }
}
