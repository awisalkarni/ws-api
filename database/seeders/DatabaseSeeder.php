<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ZoneSeeder::class);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@ws-api.test',
            'password' => bcrypt('password'),
        ]);
    }
}
