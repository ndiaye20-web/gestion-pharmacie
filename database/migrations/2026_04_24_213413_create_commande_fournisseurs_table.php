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
    Schema::create('commande_fournisseurs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fournisseur_id')->constrained();
        $table->date('date_commande');
        $table->date('date_reception')->nullable();
        $table->decimal('total', 10, 2)->default(0);
        $table->string('bon_livraison')->nullable();
        $table->string('statut')->default('en_attente');
    });
   }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_fournisseurs');
    }
};
