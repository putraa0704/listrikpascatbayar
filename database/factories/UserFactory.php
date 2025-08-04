<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'nama_user' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'level_id' => Level::firstOrCreate(['id' => 1], ['nama_level' => 'admin'])->id,

        ];

    }
}