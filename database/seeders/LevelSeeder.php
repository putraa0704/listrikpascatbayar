<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        Level::firstOrCreate(['id' => 1], ['nama_level' => 'administrator']);
        Level::firstOrCreate(['id' => 2], ['nama_level' => 'petugas']);

    }
}
