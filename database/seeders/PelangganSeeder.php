<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        Pelanggan::create([
            'nama_pelanggan' => 'andra',
            'username' => 'dra3',
            'password' => Hash::make('password'),
            'alamat' => 'Jl.Pitara',
            'nomor_kwh' => '12322156',
            'tarif_id' => 3 // id tarif dari seeder
        ]);
    }
}