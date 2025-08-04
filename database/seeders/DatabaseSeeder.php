<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TarifSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(UserSeeder::class);
    }
}
