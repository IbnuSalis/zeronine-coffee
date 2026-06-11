<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        if ($request->role) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,cashier,customer',
            'phone'    => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => bcrypt($validated['password']),
            'phone'             => $validated['phone'] ?? null,
            'email_verified_at' => now(),
        ]);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,cashier,customer',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);
        $user->syncRoles([$validated['role']]);

        if ($request->password) {
            $request->validate(['password' => 'min:8']);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus!');
    }
}
