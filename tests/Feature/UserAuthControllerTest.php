<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Level::factory()->create(['id' => 1, 'nama_level' => 'Admin']);
        Level::factory()->create(['id' => 2, 'nama_level' => 'Petugas']);
    }

    /** @test */
    public function admin_can_login_and_redirect_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'username' => 'adminuser',
            'password' => bcrypt('password'),
            'level_id' => 1,
        ]);

        $response = $this->post('/login', [
            'username' => 'adminuser',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin, 'web');
    }

    /** @test */
    public function petugas_can_login_and_redirect_to_petugas_dashboard()
    {
        $petugas = User::factory()->create([
            'username' => 'petugasuser',
            'password' => bcrypt('password'),
            'level_id' => 2,
        ]);

        $response = $this->post('/login', [
            'username' => 'petugasuser',
            'password' => 'password',
        ]);

        $response->assertRedirect('/petugas/dashboard');
        $this->assertAuthenticatedAs($petugas, 'web');
    }

    /** @test */
    public function pelanggan_can_login_and_redirect_to_dashboard()
    {
        // Pastikan tarif_id tersedia
        \App\Models\Tarif::factory()->create([
            'id' => 1,
            'daya' => 1300,
            'tarif_perkwh' => 1500,
        ]);

        $pelanggan = \App\Models\Pelanggan::factory()->create([
            'username' => 'pelangganuser',
            'password' => bcrypt('password'),
            'tarif_id' => 1,
        ]);

        $response = $this->post('/login', [
            'username' => 'pelangganuser',
            'password' => 'password',
        ]);

        $response->assertRedirect('/pelanggan/dashboard');
        $this->assertAuthenticatedAs($pelanggan, 'pelanggan');
    }
    /** @test */
    public function login_fails_with_wrong_credentials()
    {
        $response = $this->from('/login')->post('/login', [
            'username' => 'notfound',
            'password' => 'wrong',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('username');
        $this->assertGuest(); // tidak login
    }

    /** @test */
    public function logout_clears_session_and_redirects_to_login()
    {
        $user = User::factory()->create([
            'username' => 'adminuser',
            'password' => bcrypt('password'),
            'level_id' => 1,
        ]);

        $this->actingAs($user, 'web');

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest('web');
    }

}
