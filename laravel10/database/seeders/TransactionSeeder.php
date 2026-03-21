<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;        
use Faker\Factory as Faker;       

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $userIds = DB::table('users')->pluck('id')->toArray();
        $serviceIds = DB::table('services')->pluck('id')->toArray();
        $doctorIds = DB::table('doctors')->pluck('id')->toArray();
        if (empty($userIds) || empty($serviceIds) || empty($doctorIds)) {
            $this->command->info("Salah satu tabel master (users/services/doctors) kosong!");
            return;
        }

        for ($i = 0; $i < 15; $i++) {
            DB::table('transactions')->insert([
                'transaction_code' => 'TRV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
                'user_id' => $faker->randomElement($userIds),
                'service_id' => $faker->randomElement($serviceIds),
                'doctor_id' => $faker->randomElement($doctorIds),
                'total_price' => $faker->numberBetween(50000, 500000),
                'appointment_date' => $faker->dateTimeBetween('now', '+1 month'),
                'user_notes' => $faker->sentence(),
                'status' => $faker->randomElement(['pending', 'completed', 'cancelled']),
                'created_at' => now(), 
                'updated_at' => now(),
            ]);
        }
    }
}