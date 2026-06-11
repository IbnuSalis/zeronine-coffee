<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::orderBy('number')->paginate(20);
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number'   => 'required|integer|unique:tables,number',
            'name'     => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
            'location' => 'nullable|string|max:100',
            'status'   => 'required|in:available,occupied,reserved,maintenance',
            'is_active'=> 'boolean',
            'notes'    => 'nullable|string',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Table::create($validated);
        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil ditambahkan!');
    }

    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'number'   => 'required|integer|unique:tables,number,' . $table->id,
            'name'     => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
            'location' => 'nullable|string|max:100',
            'status'   => 'required|in:available,occupied,reserved,maintenance',
            'is_active'=> 'boolean',
            'notes'    => 'nullable|string',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $table->update($validated);
        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil diperbarui!');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return back()->with('success', 'Meja berhasil dihapus!');
    }
}
