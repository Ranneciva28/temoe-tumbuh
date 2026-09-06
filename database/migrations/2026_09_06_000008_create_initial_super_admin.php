<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $email = 'rabamabama28@gmail.com';
        $now = now();

        $existing = DB::table('users')->where('email', $email)->exists();

        if ($existing) {
            DB::table('users')->where('email', $email)->update([
                'name' => 'Super Admin',
                'password' => '$2b$12$ImeFEkmCK5Ouf0f9zE2pqO7nnT.3sH0EddP1NfsuzWucXUMHWPh7C',
                'updated_at' => $now,
            ]);

            return;
        }

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => $email,
            'password' => '$2b$12$ImeFEkmCK5Ouf0f9zE2pqO7nnT.3sH0EddP1NfsuzWucXUMHWPh7C',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        // Akun tidak dihapus saat rollback agar akses admin tidak hilang.
    }
};
