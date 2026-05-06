<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('ordonnances', function (Blueprint $table) {
        if (!Schema::hasColumn('ordonnances', 'statut')) {
    $table->string('statut')->default('en_attente');
    }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordonnances', function (Blueprint $table) {
            //
        });
    }
};
