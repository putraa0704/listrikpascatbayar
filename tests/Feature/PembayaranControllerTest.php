<?php

namespace Tests\Feature;

use App\Models\Pembayaran;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\Level;

class PembayaranControllerTest extends TestCase
{
    use RefreshDatabase;

    

protected function setUp(): void
{
    parent::setUp();

    // Tambahkan level admin sebelum membuat user
    Level::factory()->create([
        'id' => 1,
        'nama_level' => 'admin'
    ]);
}


    public function test_admin_can_view_pembayaran_index()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $response = $this->get(route('admin.pembayarans.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pembayaran.index');
    }

    public function test_admin_can_open_create_form()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $response = $this->get(route('admin.pembayarans.create'));
        $response->assertStatus(200);
        $response->assertViewIs('pembayaran.create');
    }

    public function test_admin_can_store_pembayaran()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $tarif = Tarif::factory()->create(['daya' => 900]);
        $pelanggan = Pelanggan::factory()->create(['tarif_id' => $tarif->id]);
        $tagihan = Tagihan::factory()->create([
            'pelanggan_id' => $pelanggan->id,
            'jumlah_meter' => 100,
            'status_tagihan' => 'Belum Dibayar'
        ]);

        $data = [
            'tagihan_id' => $tagihan->id,
            'tanggal_pembayaran' => now()->toDateString(),
            'biaya_admin' => 2000,
        ];

        $response = $this->post(route('admin.pembayarans.store'), $data);

        $this->assertDatabaseHas('pembayaran', [
            'tagihan_id' => $tagihan->id,
            'pelanggan_id' => $pelanggan->id,
            'user_id' => $admin->id,
            'biaya_admin' => 2000,
        ]);

        $this->assertEquals('Sudah Dibayar', $tagihan->fresh()->status_tagihan);

        $response->assertRedirect(route('admin.pembayarans.index'));
    }

    public function test_admin_can_edit_pembayaran()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $pembayaran = Pembayaran::factory()->create();

        $response = $this->get(route('admin.pembayarans.edit', $pembayaran));
        $response->assertStatus(200);
        $response->assertViewIs('pembayaran.edit');
    }

    public function test_admin_can_update_pembayaran()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $pembayaran = Pembayaran::factory()->create([
            'biaya_admin' => 1000,
        ]);

        $response = $this->put(route('admin.pembayarans.update', $pembayaran), [
            'tanggal_pembayaran' => now()->toDateString(),
            'biaya_admin' => 3000,
        ]);

        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'biaya_admin' => 3000,
        ]);

        $response->assertRedirect(route('admin.pembayarans.index'));
    }

    public function test_admin_can_delete_pembayaran()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $this->actingAs($admin, 'web');

        $pembayaran = Pembayaran::factory()->create();
        $tagihan = $pembayaran->tagihan;
        $tagihan->update(['status_tagihan' => 'Sudah Dibayar']);

        $response = $this->delete(route('admin.pembayarans.destroy', $pembayaran));

        $this->assertDatabaseMissing('pembayaran', ['id' => $pembayaran->id]);
        $this->assertEquals('Belum Dibayar', $tagihan->fresh()->status_tagihan);

        $response->assertRedirect(route('admin.pembayarans.index'));
    }
}
