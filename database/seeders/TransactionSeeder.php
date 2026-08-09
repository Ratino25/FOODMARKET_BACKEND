<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Seed dummy transaction data.
     */
    public function run(): void
    {
        // Hindari duplikasi jika seeder sudah pernah dijalankan
        if (DB::table('transactions')->exists()) {
            $this->command->warn('Data transaksi sudah ada. Lewati seeding dummy transaksi.');
            return;
        }

        // Ambil semua data food yang sudah tersedia (dari migration seed food dummy)
        $foods = Food::all();

        if ($foods->isEmpty()) {
            $this->command->warn('Tidak ada data food. Jalankan `php artisan migrate` terlebih dahulu agar data dummy food tersedia.');
            return;
        }

        // Siapkan user dengan role USER sebagai pemilik transaksi
        $users = User::where('roles', 'USER')->get();

        if ($users->count() < 6) {
            $need = 6 - $users->count();

            for ($i = 0; $i < $need; $i++) {
                $users->push(User::factory()->create([
                    'roles' => 'USER',
                    'address' => fake()->streetAddress(),
                    'houseNumber' => (string) fake()->numberBetween(1, 200),
                    'phoneNumber' => fake()->phoneNumber(),
                    'city' => fake()->city(),
                ]));
            }
        }

        // Daftar status dengan bobot (SUCCESS lebih sering muncul agar dashboard terlihat hidup)
        $statuses = [
            'SUCCESS', 'SUCCESS', 'SUCCESS', 'DELIVERED', 'DELIVERED',
            'PENDING', 'ON_DELIVERY', 'CANCELLED',
        ];

        $transactions = [];

        for ($i = 0; $i < 30; $i++) {
            $food = $foods->random();
            $user = $users->random();
            $quantity = fake()->numberBetween(1, 5);
            $status = fake()->randomElement($statuses);
            $createdAt = now()
                ->subDays(fake()->numberBetween(0, 60))
                ->subHours(fake()->numberBetween(0, 23))
                ->subMinutes(fake()->numberBetween(0, 59));

            $transactions[] = [
                'user_id' => $user->id,
                'food_id' => $food->id,
                'quantity' => $quantity,
                'total' => $food->price * $quantity,
                'status' => $status,
                'payment_url' => in_array($status, ['PENDING', 'ON_DELIVERY'])
                    ? 'https://app.sandbox.midtrans.com/snap/v4/redirection/' . str()->random(20)
                    : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        DB::table('transactions')->insert($transactions);

        $this->command->info('Berhasil membuat ' . count($transactions) . ' data transaksi dummy.');
    }
}
