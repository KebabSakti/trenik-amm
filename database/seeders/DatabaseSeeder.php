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

        for ($i = 0; $i <= 100; $i++) {
            DB::table('products')->insert([
                'company_id' => 1,
                'product_name' => $faker->word(),
                'product_brand' => $faker->word(),
                'price_1x' => $faker->numberBetween(),
                'credit_1x' => $faker->numberBetween(),
                'price_3x' => $faker->numberBetween(),
                'credit_3x' => $faker->numberBetween(),
                'price_6x' => $faker->numberBetween(),
                'credit_6x' => $faker->numberBetween(),
                'price_9x' => $faker->numberBetween(),
                'credit_9x' => $faker->numberBetween(),
                'price_12x' => $faker->numberBetween(),
                'credit_12x' => $faker->numberBetween(),
                'active' => 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
        }
    }
}
