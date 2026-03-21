<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Carbon\Carbon; // Untuk manipulasi waktu

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
    [
        'name' => 'Konsultasi Dokter Online',
        'description' => 'Layanan konsultasi...',
        'available_from' => '08:00:00',
        'available_to' => '21:00:00',
        'category_id' => 1, 
        'price' => 50000, 
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}