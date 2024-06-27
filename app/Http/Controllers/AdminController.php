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
            $query->where(function($q) use ($search) {
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
}
