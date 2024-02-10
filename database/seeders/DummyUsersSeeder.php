<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $userData = [
                'name' => 'king',
                'email' => 'king@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('123')
            ];

            
                User::create($userData);
            
        }
    }
