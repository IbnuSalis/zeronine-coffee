<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(15);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'          => 'required|string|max:50|unique:promos,code',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'type'          => 'required|in:percentage,fixed',
            'value'         => 'required|numeric|min:0',
            'min_spend'     => 'nullable|numeric|min:0',
            'max_discount'  => 'nullable|numeric|min:0',
            'usage_limit'   => 'nullable|integer|min:1',
            'per_user_limit'=> 'nullable|integer|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'is_active'     => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Promo::create($validated);
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'code'          => 'required|string|max:50|unique:promos,code,' . $promo->id,
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'type'          => 'required|in:percentage,fixed',
            'value'         => 'required|numeric|min:0',
            'min_spend'     => 'nullable|numeric|min:0',
            'max_discount'  => 'nullable|numeric|min:0',
            'usage_limit'   => 'nullable|integer|min:1',
            'per_user_limit'=> 'nullable|integer|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date',
            'is_active'     => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $promo->update($validated);
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return back()->with('success', 'Promo berhasil dihapus!');
    }
}
