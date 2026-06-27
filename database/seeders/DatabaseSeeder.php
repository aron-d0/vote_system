<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::where('email', 'aron@example.com')->delete();

        $demoUsers = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ],
            [
                'name' => 'Mariphil Marigmen',
                'email' => 'mariphilmarigmen11@gmail.com',
                'password' => '12345678',
            ],
        ];

        foreach ($demoUsers as $demoUser) {
            User::updateOrCreate(
                ['email' => $demoUser['email']],
                [
                    'name' => $demoUser['name'],
                    'password' => Hash::make($demoUser['password']),
                    'is_admin' => false,
                ]
            );
        }

        $this->call(AdminUserSeeder::class);
        $this->call(SampleElectionSeeder::class);
    }
}
