<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'kreseknururrahmah@gmail.com']);
        $admin->fill([
            'name' => 'Administrator',
            'password' => 'password123',
        ]);
        $admin->email_verified_at = now();
        $admin->is_admin = true;
        $admin->save();

        $user = User::firstOrNew(['email' => 'user@nururrahmah.sch.id']);
        $user->fill([
            'name' => 'Santri Contoh',
            'password' => 'password123',
        ]);
        $user->email_verified_at = now();
        $user->is_admin = false;
        $user->save();
    }
}
