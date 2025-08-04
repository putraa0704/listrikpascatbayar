<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition()
    {

        
        return [
            'tagihan_id' => Tagihan::factory(),
            'pelanggan_id' => Pelanggan::factory(),
            'user_id' => User::factory(),
            'tanggal_pembayaran' => $this->faker->date(),
            'biaya_admin' => 2000,
            'total_bayar' => 50000,
            'status' => 'success',
        ];
    }
}
