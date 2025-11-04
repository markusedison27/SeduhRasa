@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-4 border">
            <h2 class="text-sm font-medium text-stone-500">Total Users</h2>
            <p class="text-3xl font-extrabold mt-1">120</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 border">
            <h2 class="text-sm font-medium text-stone-500">Active Sessions</h2>
            <p class="text-3xl font-extrabold mt-1">45</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 border">
            <h2 class="text-sm font-medium text-stone-500">Revenue</h2>
            <p class="text-3xl font-extrabold mt-1">Rp 3.200.000</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 border">
        <h2 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h2>
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-stone-100 text-left">
                    <th class="p-2 border">User</th>
                    <th class="p-2 border">Aktivitas</th>
                    <th class="p-2 border">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-stone-50">
                    <td class="p-2 border">John Doe</td>
                    <td class="p-2 border">Login</td>
                    <td class="p-2 border">2025-09-08</td>
                </tr>
                <tr class="hover:bg-stone-50">
                    <td class="p-2 border">Jane Smith</td>
                    <td class="p-2 border">Update Profil</td>
                    <td class="p-2 border">2025-09-07</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
