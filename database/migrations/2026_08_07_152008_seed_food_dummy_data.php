<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('food')->insert([
            [
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan ayam suwir, telur, dan sayuran segar dengan bumbu khas.',
                'ingredients' => 'Nasi, telur, ayam suwir, wortel, kecap manis, bawang merah, bawang putih',
                'price' => 25000,
                'rate' => 4.8,
                'types' => 'Makanan Berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mie Ayam Bakso',
                'description' => 'Mie ayam gurih dengan topping ayam cincang dan bakso sapi kenyal.',
                'ingredients' => 'Mie, ayam cincang, bakso, sawi hijau, bawang goreng, kuah kaldu',
                'price' => 20000,
                'rate' => 4.7,
                'types' => 'Makanan Berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sate Ayam',
                'description' => 'Sate ayam empuk dibakar dengan bumbu kacang yang gurih dan manis.',
                'ingredients' => 'Daging ayam, bumbu kacang, kecap manis, bawang merah, lontong',
                'price' => 30000,
                'rate' => 4.6,
                'types' => 'Makanan Berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gado-Gado',
                'description' => 'Sayuran segar dengan saus kacang, telur rebus, dan kerupuk.',
                'ingredients' => 'Kacang panjang, tauge, kol, kentang, tahu, tempe, saus kacang',
                'price' => 18000,
                'rate' => 4.5,
                'types' => 'Makanan Sehat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rendang Sapi',
                'description' => 'Daging sapi empuk dimasak dengan santan dan rempah-rempah khas Padang.',
                'ingredients' => 'Daging sapi, santan, serai, daun jeruk, cabai, lengkuas',
                'price' => 45000,
                'rate' => 4.9,
                'types' => 'Makanan Berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Soto Ayam',
                'description' => 'Sup ayam berkuah kuning dengan soun, kol, dan perasan jeruk nipis.',
                'ingredients' => 'Ayam, kunyit, soun, kol, telur rebus, bawang goreng, jeruk nipis',
                'price' => 22000,
                'rate' => 4.6,
                'types' => 'Makanan Berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bakso Sapi',
                'description' => 'Bakso sapi kenyal dengan kuah kaldu gurih, mi, dan tahu goreng.',
                'ingredients' => 'Daging sapi, tepung kanji, mi, tahu, bawang goreng, seledri',
                'price' => 20000,
                'rate' => 4.7,
                'types' => 'Makanan Berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Teh dingin segar dengan gula alami, penyegar dahaga terbaik.',
                'ingredients' => 'Teh hitam, gula, es batu',
                'price' => 5000,
                'rate' => 4.5,
                'types' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Es Jeruk',
                'description' => 'Perasan jeruk segar dengan es batu, manis dan asam yang menyegarkan.',
                'ingredients' => 'Jeruk peras, gula, es batu',
                'price' => 8000,
                'rate' => 4.4,
                'types' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pisang Goreng',
                'description' => 'Pisang goreng crispy dengan taburan gula halus, cocok untuk camilan.',
                'ingredients' => 'Pisang raja, tepung terigu, gula halus, minyak goreng',
                'price' => 10000,
                'rate' => 4.3,
                'types' => 'Cemilan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('food')->whereIn('name', [
            'Nasi Goreng Spesial',
            'Mie Ayam Bakso',
            'Sate Ayam',
            'Gado-Gado',
            'Rendang Sapi',
            'Soto Ayam',
            'Bakso Sapi',
            'Es Teh Manis',
            'Es Jeruk',
            'Pisang Goreng',
        ])->delete();
    }
};
