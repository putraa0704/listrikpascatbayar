<?php

namespace Database\Factories;

use App\Models\Tarif;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarifFactory extends Factory
{
    protected $model = Tarif::class;

    public function definition(): array
    {
        static $dayaValues = [450, 900, 1300, 2200, 3500, 4400];
        static $index = 0;

        if ($index >= count($dayaValues)) {
            $index = 0; // atau throw error kalau mau batasi
        }

        return [
            'daya' => $dayaValues[$index++],
            'tarif_perkwh' => $this->faker->numberBetween(1000, 1500),
        ];
    }


}
