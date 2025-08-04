<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_dashboard()
    {
        // Tambahkan level admin terlebih dahulu
        $adminLevel = Level::create(['nama_level' => 'Admin']);

        // Buat user admin
        $admin = User::factory()->create([
            'level_id' => $adminLevel->id,
        ]);

        // Login sebagai admin
        $this->actingAs($admin, 'web');

        // Akses dashboard
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function petugas_can_view_dashboard()
    {
        // Tambahkan level petugas terlebih dahulu
        $petugasLevel = Level::create(['nama_level' => 'Petugas']);

        // Buat user petugas
        $petugas = User::factory()->create([
            'level_id' => $petugasLevel->id,
        ]);

        // Login sebagai petugas
        $this->actingAs($petugas, 'web');

        // Akses dashboard
        $response = $this->get(route('petugas.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('petugas.dashboard');
    }
}
