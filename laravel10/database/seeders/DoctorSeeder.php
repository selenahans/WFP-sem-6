<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Faker\Factory as Faker;        

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); 
        for ($i = 1; $i <= 5; $i++) {
            DB::table('doctors')->insert([
                'name' => $faker->name('male' | 'female'),
                'specialist' => $faker->randomElement([
                    'Dokter Umum', 
                    'Spesialis Anak', 
                    'Spesialis Penyakit Dalam', 
                    'Spesialis Saraf', 
                    'Dokter Gigi'
                ]),
                'license_number' => 'STR-' . $faker->bothify('##########'), 
                'phone_number' => $faker->phoneNumber(),
                'bio' => $faker->paragraph(), 
                'photo' => 'doctor_' . $i . '.jpg', 
                'experience_years' => $faker->numberBetween(1, 25),
                'is_active' => true,
                'created_at' => now(), 
                'updated_at' => now(),
            ]);
        }
    }
}