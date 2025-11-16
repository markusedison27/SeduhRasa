<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    // ==========================
    // ADMIN MENU (admin.menus.*)
    // ==========================

    public function index()
    {
        return view('menus.index'); // sudah ada
    }

    public function create()
    {
        return view('menus.create'); // pastikan view ini ada
    }

    public function store(Request $request)
    {
        // TODO: simpan ke DB (sementara kita terima saja)
        return back()->with('success', 'Menu berhasil ditambahkan (dummy).');
    }

    // ==========================
    // HALAMAN ORDER PUBLIK /order
    // ==========================
    public function publicOrder()
    {
        // sementara: data menu dummy (supaya kelihatan dulu)
        $menus = [
            [
                'category' => 'Coffee',
                'items' => [
                    [
                        'name'  => 'Espresso',
                        'price' => 18000,
                        'image' => 'https://images.unsplash.com/photo-1510626176961-4b37d6af3c4a?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name'  => 'Cappuccino',
                        'price' => 23000,
                        'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name'  => 'Latte',
                        'price' => 24000,
                        'image' => 'https://images.unsplash.com/photo-1521302080371-6c5f60b67f36?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name'  => 'Americano',
                        'price' => 20000,
                        'image' => 'https://images.unsplash.com/photo-1521302080371-6c5f60b67f36?q=80&w=800&auto=format&fit=crop',
                    ],
                ],
            ],
            [
                'category' => 'Snack',
                'items' => [
                    [
                        'name'  => 'Croissant',
                        'price' => 15000,
                        'image' => 'https://images.unsplash.com/photo-1606755962773-d324e0a13058?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name'  => 'Muffin',
                        'price' => 14000,
                        'image' => 'https://images.unsplash.com/photo-1605478371319-4c5d9a5e9a1b?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name'  => 'Donut',
                        'price' => 13000,
                        'image' => 'https://images.unsplash.com/photo-1606312619070-2049f3a6f3ee?q=80&w=800&auto=format&fit=crop',
                    ],
                    [
                        'name'  => 'Cheese Cake',
                        'price' => 18000,
                        'image' => 'https://images.unsplash.com/photo-1605478371319-4c5d9a5e9a1b?q=80&w=800&auto=format&fit=crop',
                    ],
                ],
            ],
        ];

        return view('order', compact('menus'));
    }
}
