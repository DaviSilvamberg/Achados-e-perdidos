<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use InvalidArgumentException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (blank($email) && blank($password)) {
            $this->command?->warn('Administrador não criado: configure ADMIN_EMAIL e ADMIN_PASSWORD no .env.');

            return;
        }

        if (blank($email) || blank($password)) {
            throw new InvalidArgumentException('Configure ADMIN_EMAIL e ADMIN_PASSWORD juntos no arquivo .env.');
        }

        $admin = User::firstOrNew(['email' => $email]);
        $admin->name = $admin->name ?: 'Administrador';
        $admin->password = $password;
        $admin->is_admin = true;
        $admin->save();
    }
}
