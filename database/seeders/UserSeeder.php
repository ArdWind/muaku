<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' => 'admin@gmail.com', 'Status' => 'active', 'role' => 'admin', 'password' => 'admin']);
        User::create(['name' => 'staff', 'email' => 'staff@gmail.com', 'Status' => 'active', 'role' => 'staff', 'password' => 'staff']);
        User::create(['name' => 'customer', 'email' => 'customer@gmail.com', 'Status' => 'active', 'role' => 'customer', 'password' => 'customer']);
    }
}
