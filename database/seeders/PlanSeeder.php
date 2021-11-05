<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Osiset\ShopifyApp\Storage\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Plan();
        $user->type = 'RECURRING';
        $user->name = 'Basic Plan';
        $user->price = 1.99;
        $user->interval = 'EVERY_30_DAYS';
        $user->capped_amount = 1.99;
        $user->terms = 'Basic Plan Terms';
        $user->trial_days = 1;
        $user->test = 1;
        $user->on_install = 1;
        $user->save();

    }
}
