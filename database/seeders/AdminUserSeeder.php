<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = strtolower(trim((string) env('ADMIN_EMAIL', 'admin@example.com')));
        $password = (string) env('ADMIN_PASSWORD', 'password123');

        $admin = User::firstOrNew(['email' => $email]);

        $admin->name = $admin->exists ? $admin->name : (string) env('ADMIN_NAME', 'Admin User');
        $admin->is_admin = true;

        if (! $admin->exists) {
            $admin->password = $password;
        }

        $admin->save();
    }
}
