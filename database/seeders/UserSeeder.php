<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data 4 akun admin/pemilik
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@seduhrasa.com',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pemilik 1 (Kasir)',
                'email' => 'kasir1@seduhrasa.com',
                'password' => Hash::make('kasir123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pemilik 2 (Manajer)',
                'email' => 'manager@seduhrasa.com',
                'password' => Hash::make('manager123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pemilik 3 (Barista)',
                'email' => 'barista@seduhrasa.com',
                'password' => Hash::make('barista123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Masukkan data ke tabel 'users' (atau 'pemilik', sesuaikan Model Anda)
        DB::table('users')->insert($users);
    }
}