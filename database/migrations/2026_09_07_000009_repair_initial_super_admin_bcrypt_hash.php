<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $email = 'rabamabama28@gmail.com';
        $legacyHash = '$2b$12$ImeFEkmCK5Ouf0f9zE2pqO7nnT.3sH0EddP1NfsuzWucXUMHWPh7C';
        $phpBcryptHash = '$2y$12$ImeFEkmCK5Ouf0f9zE2pqO7nnT.3sH0EddP1NfsuzWucXUMHWPh7C';

        DB::table('users')
            ->where('email', $email)
            ->where('password', $legacyHash)
            ->update([
                'password' => $phpBcryptHash,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Jangan kembalikan akun ke format hash yang ditolak Laravel.
    }
};
