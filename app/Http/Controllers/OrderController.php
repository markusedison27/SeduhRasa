<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan halaman order
    public function index()
    {
        return view('order'); // akan memanggil resources/views/order.blade.php
    }
}
