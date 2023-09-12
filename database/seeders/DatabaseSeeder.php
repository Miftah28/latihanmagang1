<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\AdminDaerah;
use App\Models\Daerah;
use App\Models\Kota;
use App\Models\Supir;
use App\Models\User;
use Illuminate\Database\Seeder;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Admin
        $user = User::create([
            'email' => 'miftah@gmail.com',
            'password' => bcrypt('@Miftahus1'),
            'role' => 'admin',
        ]);
        if ($user) {
            Admin::create([
                'name' => 'Miftahus 1',
                'user_id' => $user->id
            ]);
        }
        // Admin Daerah
        $user = User::create([
            'email' => 'miftahus@gmail.com',
            'password' => bcrypt('@Miftahus2'),
            'role' => 'admindaerah',
        ]);
        $kota = Kota::create([
            'nama_kota' => 'Purwakarta'
        ]);
        $daerah = Daerah::create([
            'kota_id' => $kota->id,
            'nama_daerah' => 'sadang',
        ]);
        if ($user && $daerah) {
            AdminDaerah::create([
                'nama' => 'Miftahus 2',
                'kota_id' => $kota->id,
                'user_id' => $user->id,
                'daerah_id' => $daerah->id
            ]);
        }
        // Supir
        $user = User::create([
            'email' => 'miftahus1@gmail.com',
            'password' => bcrypt('@Miftahus3'),
            'role' => 'supir',
        ]);
        if ($user) {
            Supir::create([
                'nama' => 'Miftahus 3',
                'user_id' => $user->id
            ]);
        }
    }
}
