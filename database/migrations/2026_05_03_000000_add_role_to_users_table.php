<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // This migration is handled by the newer fix_role_column_size migration
        // Keeping this for compatibility with existing deployments
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is handled by the newer fix_role_column_size migration
    }
};
