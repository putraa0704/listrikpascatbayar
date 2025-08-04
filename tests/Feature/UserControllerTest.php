<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed level (admin dan petugas)
        Level::factory()->create(['id' => 1, 'nama_level' => 'administrator']);
        Level::factory()->create(['id' => 2, 'nama_level' => 'petugas']);
    }

    /** @test */
    public function admin_can_access_user_index()
    {
        $admin = User::factory()->create(['level_id' => 1]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user.index');
    }

    /** @test */
    public function non_admin_cannot_access_user_index()
    {
        $petugas = User::factory()->create(['level_id' => 2]);

        $response = $this->actingAs($petugas)->get(route('admin.users.index'));

        $response->assertForbidden(); // atau assertStatus(403)

    }

    /** @test */
    public function admin_can_create_user()
    {
        $admin = User::factory()->create(['level_id' => 1]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'nama_user' => 'Test User',
            'username' => 'testuser',
            'password' => 'password123',
            'level_id' => 2,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['username' => 'testuser']);
    }

    /** @test */
    public function admin_can_update_user()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $user = User::factory()->create([
            'nama_user' => 'User Lama',
            'username' => 'lamauser',
            'level_id' => 2
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user->id), [
            'nama_user' => 'User Baru',
            'username' => 'baruuser',
            'level_id' => 2,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['username' => 'baruuser']);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $admin = User::factory()->create(['level_id' => 1]);
        $user = User::factory()->create(['level_id' => 2]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user->id));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function admin_cannot_delete_self()
    {
        $admin = User::factory()->create(['level_id' => 1]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));

        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /** @test */
    public function cannot_delete_last_admin()
    {
        $admin = User::factory()->create(['level_id' => 1]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));

        $response->assertSessionHas('error');
    }
}
