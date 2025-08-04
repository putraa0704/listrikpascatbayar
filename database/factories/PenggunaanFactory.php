<?php

namespace Database\Factories;

use App\Models\Penggunaan;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenggunaanFactory extends Factory
{
    protected $model = Penggunaan::class;

    public function definition()
    {
        return [
            'pelanggan_id' => Pelanggan::factory(),
            'bulan' => $this->faker->month,
            'tahun' => $this->faker->year,
            'meter_awal' => $this->faker->numberBetween(1000, 2000),
            'meter_akhir' => $this->faker->numberBetween(2001, 3000),
        ];
    }
}
