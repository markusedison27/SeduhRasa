<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerController extends Controller
{
    /**
     * Dashboard Owner
     */
    public function index(): View
    {
        $owner = Auth::user();   // user yang lagi login (role: owner)

        return view('owner.dashboard', compact('owner'));
    }

    /**
     * Halaman keuangan owner
     */
    public function finance(): View
    {
        $owner = Auth::user();

        return view('owner.finance', compact('owner'));
    }
}
