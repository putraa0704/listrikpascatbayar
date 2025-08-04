<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LevelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_level()
    {
        $level = Level::create([
            'nama_level' => 'Admin',
        ]);

        $this->assertDatabaseHas('level', [
            'nama_level' => 'Admin',
        ]);
    }

    /** @test */
    public function it_has_many_users()
    {
        $level = Level::create(['nama_level' => 'Petugas']);

        $user1 = User::factory()->create(['level_id' => $level->id]);
        $user2 = User::factory()->create(['level_id' => $level->id]);

        $this->assertCount(2, $level->users);
        $this->assertTrue($level->users->contains($user1));
        $this->assertTrue($level->users->contains($user2));
    }
}
