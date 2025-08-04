<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PelangganDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $pelanggan = Pelanggan::factory()->create();
        $this->actingAs($pelanggan, 'pelanggan');
        return $pelanggan;
    }

    /** @test */
    public function pelanggan_can_view_dashboard()
    {
        $pelanggan = $this->authenticate();

        $response = $this->get(route('pelanggan.dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('pelanggan.dashboard');
    }

    /** @test */
    public function pelanggan_can_view_tagihan_saya()
    {
        $pelanggan = $this->authenticate();

        Tagihan::factory()->count(3)->create([
            'pelanggan_id' => $pelanggan->id,
        ]);

        $response = $this->get(route('pelanggan.tagihan_saya'));
        $response->assertStatus(200);
        $response->assertViewIs('pelanggan.tagihan_saya');
        $response->assertViewHas('tagihans');
    }

    /** @test */
    public function pelanggan_can_view_riwayat_pembayaran()
    {
        $pelanggan = $this->authenticate();

        $response = $this->get(route('pelanggan.riwayat_pembayaran'));
        $response->assertStatus(200);
        $response->assertViewIs('pelanggan.riwayat_pembayaran');
        $response->assertViewHas('riwayatPembayaran');
    }

    /** @test */
    public function pelanggan_can_view_profil()
    {
        $pelanggan = $this->authenticate();

        $response = $this->get(route('pelanggan.profil_saya'));
        $response->assertStatus(200);
        $response->assertViewIs('pelanggan.profil_saya');
    }

    /** @test */
    public function pelanggan_can_update_profil_without_password()
    {
        $pelanggan = $this->authenticate();

        $response = $this->put(route('pelanggan.update_profil'), [
            'nama_pelanggan' => 'Nama Baru',
            'username' => 'usernamebaru',
            'alamat' => 'Alamat Baru',
        ]);

        $response->assertRedirect(route('pelanggan.profil_saya'));
        $this->assertDatabaseHas('pelanggan', ['username' => 'usernamebaru']);
    }

    /** @test */
    public function pelanggan_can_update_profil_with_password()
    {
        $pelanggan = $this->authenticate();

        $response = $this->put(route('pelanggan.update_profil'), [
            'nama_pelanggan' => 'Nama Baru',
            'username' => 'usernamebaru',
            'alamat' => 'Alamat Baru',
            'password' => 'passwordbaru',
            'password_confirmation' => 'passwordbaru',
        ]);

        $response->assertRedirect(route('pelanggan.profil_saya'));
        $this->assertDatabaseHas('pelanggan', ['username' => 'usernamebaru']);
    }

    /** @test */
    public function pelanggan_can_view_riwayat_penggunaan()
    {
        $pelanggan = $this->authenticate();

        Penggunaan::factory()->count(2)->create([
            'pelanggan_id' => $pelanggan->id,
        ]);

        $response = $this->get(route('pelanggan.riwayat_penggunaan'));
        $response->assertStatus(200);
        $response->assertViewIs('pelanggan.riwayat_penggunaan');
        $response->assertViewHas('riwayatPenggunaan');
    }
}
