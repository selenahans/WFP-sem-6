<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'General Consultation',
                'description' => 'Konsultasi umum dengan dokter untuk keluhan kesehatan ringan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Specialist Consultation',
                'description' => 'Konsultasi mendalam dengan dokter spesialis sesuai kebutuhan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Medical Checkup',
                'description' => 'Layanan pemeriksaan kesehatan menyeluruh secara rutin.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Laboratory Test',
                'description' => 'Pemeriksaan sampel darah, urin, atau hasil lab lainnya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Telemedicine',
                'description' => 'Layanan kesehatan jarak jauh melalui panggilan video atau chat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}