<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'kami',
            'email' => 'illeskalman77@gmail.com',
            'group' => 'admin',
            'password'=> 'kami',
        ]);

        $this->call([
            // ContentSeeder::class,
            ContactInfoSeeder::class,
        ]);

    }
}
