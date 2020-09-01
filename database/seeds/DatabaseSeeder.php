<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FlatSeeder::class);
        $this->call(FlatInfosSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(PromotionSeeder::class);

    }
}
