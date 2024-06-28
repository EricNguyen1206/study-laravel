<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('roles')) {
            $roles = $request->input('roles');
            if (!empty($roles)) {
                $query->whereIn('role', $roles);
            }
        }

        // Sorting
        if ($request->has('sort_order')) {
            $sortOrder = $request->input('sort_order');
            $query->orderBy('id', $sortOrder);
        } else {
            $query->orderBy('id', 'desc');
        }

        // Pagination
        $users = $query->paginate(10);

        return view('dashboard.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('dashboard.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin,operator',
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('dashboard.index')->with('success', 'User updated successfully.');
    }



    public function destroy(User $user)
    {
        // Delete user logic
        $user->delete();
        return redirect()->route('dashboard.index')->with('success', 'User deleted successfully.');
    }
}
