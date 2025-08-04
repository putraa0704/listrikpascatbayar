<?php

namespace Database\Factories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

class LevelFactory extends Factory
{
    protected $model = Level::class;

    // database/factories/LevelFactory.php
public function definition()
{
    return [
        'nama_level' => $this->faker->randomElement(['Admin', 'Petugas']),
    ];
}

}