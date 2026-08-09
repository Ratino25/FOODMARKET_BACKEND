<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed Admin User
        User::factory()->create([
            'name' => 'Admin Foodmarket',
            'email' => 'admin@foodmarket.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'roles' => 'ADMIN',
            'address' => 'Jl. Admin No. 1',
            'houseNumber' => 'A1',
            'phoneNumber' => '081234567890',
            'city' => 'Jakarta',
        ]);

        // Seed Regular User
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@foodmarket.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'roles' => 'USER',
            'address' => 'Jl. User No. 2',
            'houseNumber' => 'B2',
            'phoneNumber' => '089876543210',
            'city' => 'Bandung',
        ]);

        // Seed Dummy Transactions
        $this->call([
            TransactionSeeder::class,
        ]);
    }
}
