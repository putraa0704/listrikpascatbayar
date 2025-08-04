<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\Penggunaan;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TagihanControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'level_id' => 1,
        ]);
        $this->actingAs($this->admin);
    }

    public function test_admin_can_view_tagihan_index()
    {
        Tagihan::factory()->count(3)->create();

        $response = $this->get(route('admin.tagihans.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tagihan.index');
    }

    public function test_admin_can_access_create_from_penggunaan_page()
    {
        $response = $this->get(route('admin.tagihans.create_from_penggunaan'));

        $response->assertStatus(200);
        $response->assertViewIs('tagihan.create_from_penggunaan');
    }

    public function test_admin_can_generate_tagihan()
    {
        $tarif = Tarif::factory()->create(['tarif_perkwh' => 1500]);
        $pelanggan = Pelanggan::factory()->create(['tarif_id' => $tarif->id]);

        $penggunaan = Penggunaan::factory()->create([
            'pelanggan_id' => $pelanggan->id,
            'meter_awal' => 1000,
            'meter_akhir' => 1200,
            'bulan' => 'Januari',
            'tahun' => 2025,
        ]);

        $response = $this->post(route('admin.tagihans.generate'), [
            'penggunaan_ids' => [$penggunaan->id],
        ]);

        $response->assertRedirect(route('admin.tagihans.index'));
        $this->assertDatabaseHas('tagihan', [
            'pelanggan_id' => $pelanggan->id,
            'penggunaan_id' => $penggunaan->id,
            'jumlah_meter' => 200,
            'status_tagihan' => 'Belum Dibayar',
        ]);
    }

    public function test_admin_can_update_tagihan_status()
    {
        $tagihan = Tagihan::factory()->create([
            'status_tagihan' => 'Belum Dibayar',
        ]);

        $response = $this->put(route('admin.tagihans.update', $tagihan->id), [
            'status_tagihan' => 'Sudah Dibayar',
        ]);

        $response->assertRedirect(route('admin.tagihans.index'));
        $this->assertDatabaseHas('tagihan', [
            'id' => $tagihan->id,
            'status_tagihan' => 'Sudah Dibayar',
        ]);
    }

    public function test_admin_can_delete_tagihan()
    {
        $tagihan = Tagihan::factory()->create();

        $response = $this->delete(route('admin.tagihans.destroy', $tagihan->id));

        $response->assertRedirect(route('admin.tagihans.index'));
        $this->assertDatabaseMissing('tagihan', [
            'id' => $tagihan->id,
        ]);
    }
}
