<?php

namespace Database\Factories;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Penggunaan; 
use Illuminate\Database\Eloquent\Factories\Factory;

class TagihanFactory extends Factory
{
    protected $model = Tagihan::class;

    public function definition()
    {
        return [
            'penggunaan_id' => Penggunaan::factory(),
            'pelanggan_id' => Pelanggan::factory(),
            'bulan' => '01',
            'tahun' => 2024,
            'jumlah_meter' => 100,
            'status_tagihan' => 'Belum Dibayar',
        ];

    }
}
