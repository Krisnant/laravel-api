<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin()
    {
        // Logika untuk halaman dashboard admin
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        // Logika untuk manajemen pengguna oleh admin
        $users = User::all();
        return view('admin.manage_users', compact('users'));
    }

}
