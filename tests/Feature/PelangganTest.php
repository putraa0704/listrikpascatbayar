<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tarif;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penggunaan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PelangganTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_pelanggan()
    {
        $tarif = Tarif::factory()->create();

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => 'Andi Saputra',
            'username' => 'andis',
            'password' => bcrypt('secret'),
            'alamat' => 'Jl. Mawar No. 1',
            'nomor_kwh' => '1234567890',
            'tarif_id' => $tarif->id,
        ]);

        $pelanggan->refresh(); // Penting: agar relasi tarif ter-load

        $this->assertDatabaseHas('pelanggan', [
            'nama_pelanggan' => 'Andi Saputra',
            'username' => 'andis',
            'alamat' => 'Jl. Mawar No. 1',
        ]);

        $this->assertInstanceOf(Tarif::class, $pelanggan->tarif); // Sekarang tidak null
    }


    /** @test */
    public function it_belongs_to_tarif()
    {
        $tarif = Tarif::factory()->create(['daya' => 1300]);

        $pelanggan = Pelanggan::factory()->create([
            'tarif_id' => $tarif->id,
        ]);

        $this->assertInstanceOf(Tarif::class, $pelanggan->tarifs);
        $this->assertEquals($tarif->id, $pelanggan->tarifs->id);
    }

    /** @test */
    public function it_has_many_pengguna()
    {
        $pelanggan = Pelanggan::factory()->create();

        Penggunaan::factory()->count(2)->create([
            'pelanggan_id' => $pelanggan->id,
        ]);

        $this->assertCount(2, $pelanggan->pengguna);
    }

    /** @test */
    public function it_has_many_pembayaran()
    {
        $pelanggan = Pelanggan::factory()->create();

        Pembayaran::factory()->count(3)->create([
            'pelanggan_id' => $pelanggan->id,
        ]);

        $this->assertCount(3, $pelanggan->pembayaran);
    }
}
