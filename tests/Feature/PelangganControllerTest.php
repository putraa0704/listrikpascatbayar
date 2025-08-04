<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Level;

class PelangganControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Tambahkan level admin dan petugas
        Level::factory()->create(['id' => 1, 'nama_level' => 'admin']);
        Level::factory()->create(['id' => 2, 'nama_level' => 'petugas']);
    }

    /** @test */
    public function admin_can_view_pelanggan_index()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $response = $this->get(route('admin.pelanggans.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function petugas_can_view_pelanggan_index()
    {
        $petugas = User::factory()->create(['level_id' => 2]);
        $this->actingAs($petugas, 'web');

        $response = $this->get(route('petugas.pelanggans.index')); // UBAH KE SINI
        $response->assertStatus(200);
    }


    /** @test */
    public function guest_cannot_access_pelanggan_index()
    {
        $response = $this->get(route('admin.pelanggans.index'));
        $response->assertRedirect(route('login')); // bukan 403
    }


    /** @test */
    public function admin_can_create_pelanggan()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $tarif = Tarif::factory()->create();

        $data = [
            'tarif_id' => $tarif->id,
            'nama_pelanggan' => 'Andi Pelanggan',
            'username' => 'andipelanggan',
            'password' => 'password',
            'alamat' => 'Jalan Mawar No.123',
            'nomor_kwh' => '1234-5678-9012'
        ];

        $response = $this->post(route('admin.pelanggans.store'), $data);
        $response->assertRedirect(route('admin.pelanggans.index'));
        $this->assertDatabaseHas('pelanggan', ['username' => 'andipelanggan']);
    }

    /** @test */
    public function admin_can_edit_pelanggan()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $tarif = Tarif::factory()->create();
        $pelanggan = Pelanggan::factory()->create(['tarif_id' => $tarif->id]);

        $response = $this->get(route('admin.pelanggans.edit', $pelanggan->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pelanggans.edit');
    }

    /** @test */
    public function admin_can_update_pelanggan()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $tarif = Tarif::factory()->create();
        $pelanggan = Pelanggan::factory()->create(['tarif_id' => $tarif->id]);

        $response = $this->put(route('admin.pelanggans.update', $pelanggan->id), [
            'tarif_id' => $tarif->id,
            'nama_pelanggan' => 'Pelanggan Baru',
            'username' => $pelanggan->username,
            'alamat' => 'Alamat Baru',
            'nomor_kwh' => $pelanggan->nomor_kwh,
        ]);

        $response->assertRedirect(route('admin.pelanggans.index'));
        $this->assertDatabaseHas('pelanggan', ['nama_pelanggan' => 'Pelanggan Baru']);
    }

    /** @test */
    public function admin_can_delete_pelanggan()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $tarif = Tarif::factory()->create();
        $pelanggan = Pelanggan::factory()->create(['tarif_id' => $tarif->id]);

        $response = $this->delete(route('admin.pelanggans.destroy', $pelanggan->id));
        $response->assertRedirect(route('admin.pelanggans.index'));
        $this->assertDatabaseMissing('pelanggan', ['id' => $pelanggan->id]);
    }




}
