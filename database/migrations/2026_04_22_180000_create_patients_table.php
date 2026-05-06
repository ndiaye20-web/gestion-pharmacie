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
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('prenom');
        $table->date('date_naissance')->nullable();
        $table->string('numero_secu')->nullable();
        $table->string('mutuelle')->nullable();
        $table->text('allergies')->nullable();
        $table->text('historique')->nullable();
        $table->string('telephone')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
