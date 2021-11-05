<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Osiset\ShopifyApp\Storage\Models\Plan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PlanSeeder::class);
    }
}
