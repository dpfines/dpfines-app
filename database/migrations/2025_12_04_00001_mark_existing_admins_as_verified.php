<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mark all existing admin users as email verified to allow them to continue logging in
        // This migration ensures backward compatibility with admins created before email verification was enforced
        DB::table('users')
            ->where('is_admin', true)
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert by setting email_verified_at to NULL for existing admins
        // Comment out if you want to preserve the verified state
        // DB::table('users')
        //     ->where('is_admin', true)
        //     ->update(['email_verified_at' => null]);
    }
};
