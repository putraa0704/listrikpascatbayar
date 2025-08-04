<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use App\Models\Tarif; // ✅ Tambahkan baris ini!
use Illuminate\Database\Eloquent\Factories\Factory;

class PelangganFactory extends Factory
{
    protected $model = Pelanggan::class;

    public function definition(): array
    {
        return [
            'nama_pelanggan' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'alamat' => $this->faker->address,
            'nomor_kwh' => $this->faker->unique()->numerify('####-####-####'),
            'tarif_id' => Tarif::factory(), // pastikan ini setelah import
        ];
    }
}
