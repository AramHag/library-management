<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('admin');

        User::create([
            'name' => 'clientone',
            'email' => 'clientone@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('client');


        User::create([
            'name' => 'clienttwo',
            'email' => 'clienttwo@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('client');
    }
}
