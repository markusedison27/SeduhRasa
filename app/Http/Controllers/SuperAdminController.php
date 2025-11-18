<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // Dashboard super admin (programmer / pengelola)
    public function index()
    {
        $ownersCount = User::where('role', 'owner')->count();
        $staffCount  = User::where('role', 'staff')->count();

        return view('super_admin.dashboard', compact('ownersCount', 'staffCount'));
    }

    // List semua pemilik
    public function ownersIndex()
    {
        $owners = User::where('role', 'owner')->get();

        return view('super_admin.owners.index', compact('owners'));
    }

    // Form tambah pemilik
    public function ownersCreate()
    {
        return view('super_admin.owners.create');
    }

    // Simpan pemilik baru
    public function ownersStore(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role']     = 'owner';   // penting: role owner

        User::create($data);

        return redirect()
            ->route('super.owners.index')
            ->with('success', 'Pemilik berhasil dibuat.');
    }
}
