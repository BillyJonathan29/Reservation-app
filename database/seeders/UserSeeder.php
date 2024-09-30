<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Fikry Ramadhan',
            'username' => 'FikryRamadhan',
            'email' => 'fikryramadhan572@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'Admin'
        ]);
        User::create([
            'name' => 'Billy Jhonatan',
            'username' => 'BillyJhonatan',
            'email' => 'billyjhonatan@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'Admin'
        ]);
    }
}
