<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PenggunaanControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $admin;
    protected function setUp(): void
    {
        parent::setUp();

        // Buat user admin untuk login
        $this->admin = User::factory()->create([
            'level_id' => 1, // anggap level 1 = admin
        ]);

        // Login sebagai admin
        $this->actingAs($this->admin);
    }

    /** @test */
    public function admin_can_view_penggunaan_index()
    {
        $response = $this->get(route('admin.penggunaans.index'));

        $response->assertStatus(200);
        $response->assertViewIs('penggunaan.index');
    }

    /** @test */
    public function admin_can_view_create_form()
    {
        $response = $this->get(route('admin.penggunaans.create'));

        $response->assertStatus(200);
        $response->assertViewIs('penggunaan.create');
    }

    /** @test */
    public function admin_can_store_penggunaan()
    {
        $pelanggan = Pelanggan::factory()->create();

        $data = [
            'pelanggan_id' => $pelanggan->id,
            'bulan' => 'Januari',
            'tahun' => 2025,
            'meter_awal' => 1200,
            'meter_akhir' => 1500,
        ];

        $response = $this->post(route('admin.penggunaans.store'), $data);

        $response->assertRedirect(route('admin.penggunaans.index'));
        $this->assertDatabaseHas('penggunaan', $data);
    }

    /** @test */
    public function admin_cannot_store_duplicate_penggunaan()
    {
        $pelanggan = Pelanggan::factory()->create();

        Penggunaan::create([
            'pelanggan_id' => $pelanggan->id,
            'bulan' => 'Januari',
            'tahun' => 2025,
            'meter_awal' => 1000,
            'meter_akhir' => 1400,
        ]);

        $data = [
            'pelanggan_id' => $pelanggan->id,
            'bulan' => 'Januari',
            'tahun' => 2025,
            'meter_awal' => 1200,
            'meter_akhir' => 1500,
        ];

        $response = $this->post(route('admin.penggunaans.store'), $data);

        $response->assertSessionHasErrors('bulan');
    }

    /** @test */
    public function admin_can_update_penggunaan()
    {
        $penggunaan = Penggunaan::factory()->create([
            'meter_awal' => 1000,
            'meter_akhir' => 1400,
        ]);

        $data = [
            'pelanggan_id' => $penggunaan->pelanggan_id,
            'bulan' => $penggunaan->bulan,
            'tahun' => $penggunaan->tahun,
            'meter_awal' => 1100,
            'meter_akhir' => 1600,
        ];

        $response = $this->put(route('admin.penggunaans.update', $penggunaan), $data);

        $response->assertRedirect(route('admin.penggunaans.index'));
        $this->assertDatabaseHas('penggunaan', ['meter_awal' => 1100, 'meter_akhir' => 1600]);
    }

    /** @test */
    public function admin_can_delete_penggunaan()
    {
        $penggunaan = Penggunaan::factory()->create();

        $response = $this->delete(route('admin.penggunaans.destroy', $penggunaan));

        $response->assertRedirect(route('admin.penggunaans.index'));
        $this->assertDatabaseMissing('penggunaan', ['id' => $penggunaan->id]);
    }
}
