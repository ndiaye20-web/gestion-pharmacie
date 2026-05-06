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
    Schema::create('lots', function (Blueprint $table) {
        $table->id();
        $table->foreignId('medicament_id')->constrained();
        $table->foreignId('fournisseur_id')->nullable()->constrained();

        $table->string('numero_lot');
        $table->integer('quantite');
        $table->date('date_fabrication')->nullable();
        $table->string('statut')->default('disponible');

        $table->date('date_expiration');
        $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
