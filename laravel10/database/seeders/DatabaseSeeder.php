<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call([
            CategoriesSeeder::class,
            DoctorSeeder::class,     
            ArticleSeeder::class,    
            ServiceSeeder::class,   
            TransactionSeeder::class, 
        ]);
    }
}