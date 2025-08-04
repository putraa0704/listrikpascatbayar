<?php

namespace Tests\Feature;

use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class TarifControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\LevelSeeder::class);
    }


    private function adminUser()
    {
        return User::factory()->create(['level_id' => 1]);
    }

    public function test_admin_can_view_tarif_index()
    {
        $admin = $this->adminUser();

        Tarif::factory()->count(3)->create();

        $response = $this->actingAs($admin)->get(route('admin.tarifs.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.tarifs.index');
        $response->assertViewHas('tarifs');
    }

    public function test_admin_can_access_create_page()
    {
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)->get(route('admin.tarifs.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.tarifs.create');
    }

    public function test_admin_can_store_tarif()
    {
        $admin = $this->adminUser();

        $data = [
            'daya' => 1300,
            'tarif_perkwh' => 1500.75,
        ];

        $response = $this->actingAs($admin)->post(route('admin.tarifs.store'), $data);

        $response->assertRedirect(route('admin.tarifs.index'));
        $this->assertDatabaseHas('tarifs', $data);
    }

    public function test_admin_can_update_tarif()
    {
        $admin = $this->adminUser();
        $tarif = Tarif::factory()->create();

        $data = [
            'daya' => $tarif->daya + 100,
            'tarif_perkwh' => 1800,
        ];

        $response = $this->actingAs($admin)->put(route('admin.tarifs.update', $tarif), $data);

        $response->assertRedirect(route('admin.tarifs.index'));
        $this->assertDatabaseHas('tarifs', $data);
    }

    public function test_admin_can_delete_tarif()
    {
        $admin = $this->adminUser();
        $tarif = Tarif::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.tarifs.destroy', $tarif));

        $response->assertRedirect(route('admin.tarifs.index'));
        $this->assertDatabaseMissing('tarifs', ['id' => $tarif->id]);
    }

    public function test_non_admin_cannot_access_tarif_routes()
    {
        $petugas = User::factory()->create([
            'level_id' => 2, // Petugas
        ]);

        $this->actingAs($petugas);

        $response = $this->get(route('admin.tarifs.create'));
        $response->assertStatus(403); // <== ini seharusnya pass
    }

}
