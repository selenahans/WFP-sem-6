<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;       
use Faker\Factory as Faker;        

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $doctorIds = DB::table('doctors')->pluck('id')->toArray();
        if (empty($doctorIds)) {
            $this->command->info("Tabel doctors kosong!");
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $title = $faker->sentence(6); 
            DB::table('articles')->insert([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $faker->unique()->numberBetween(1, 1000), 
                'content' => $faker->paragraphs(3, true), 
                'image' => 'article_' . ($i + 1) . '.jpg',
                'author_id' => $faker->randomElement($doctorIds), 
                'status' => $faker->randomElement(['draft', 'published']),
                'view_count' => $faker->numberBetween(0, 500),
                'created_at' => now(), 
                'updated_at' => now(),
            ]);
        }
    }
}