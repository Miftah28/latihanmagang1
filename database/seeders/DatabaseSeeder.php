<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
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
    }
}
