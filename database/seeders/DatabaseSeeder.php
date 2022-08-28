<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i <= 200; $i++) {
            DB::table('products')->insert([
                'company_id' => 1,
                'product_name' => $faker->name(),
                'product_brand' => $faker->firstName(),
                'product_image' => 'https://via.placeholder.com/200',
                'product_description' => $faker->text(),
                'active' => 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
        }
    }
}
