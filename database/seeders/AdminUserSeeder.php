<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('admin.password');

        if (User::query()->where('is_admin', true)->exists()) {
            return;
        }

        if (blank($password)) {
            $this->command?->warn('Administrador não criado: configure ADMIN_PASSWORD no .env.');

            return;
        }

        $admin = new User;
        $admin->name = 'Administrador';
        $admin->email = 'admin@local.invalid';
        $admin->password = $password;
        $admin->is_admin = true;
        $admin->save();
    }
}
