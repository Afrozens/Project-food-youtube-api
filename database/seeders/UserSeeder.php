<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrator',
            'nickname' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin'),
            'img_url' => null,
        ]);

        $user->assignRole('Super Admin');
    }
}
