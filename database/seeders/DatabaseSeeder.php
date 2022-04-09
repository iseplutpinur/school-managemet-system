<?php

namespace Database\Seeders;

use App\Models\AddressRegencies;
use App\Models\AddressVillages;
use App\Models\User;
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
        \App\Models\User::create([
            'name' => 'Isep Lutpi Nur',
            'email' => 'iseplutpinur7@gmail.com',
            'password' => bcrypt('123456'),
            'role' => User::ROLE_ADMIN,
            'active' => '1'
        ]);
        \App\Models\User::factory(150)->create();
        AddressProvincesSeeder::run();
        AddressRegenciesSeeder::run();
        AddressDistrictsSeeder::run();
        AddressVillagesSeeder::run();
    }
}
