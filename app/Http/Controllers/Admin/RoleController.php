<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $counts = [
            'admin' => User::where('role', User::ROLE_ADMIN)->count(),
            'editor' => User::where('role', User::ROLE_EDITOR)->count(),
            'reader' => User::where('role', User::ROLE_READER)->count(),
        ];

        return view('admin.roles.index', compact('counts'));
    }
}
