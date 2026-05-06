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
    Schema::create('medicaments', function (Blueprint $table) {
        $table->id();
        $table->string('nom_commercial');
        $table->string('dci')->nullable();
        $table->string('code_cip13')->unique();
        $table->string('forme');
        $table->string('dosage');
        $table->string('classe')->nullable();
        $table->string('laboratoire')->nullable();
        $table->boolean('remboursable')->default(false);
        $table->decimal('taux_remboursement', 5, 2)->nullable();

        $table->decimal('prix_achat', 10, 2);
        $table->decimal('prix_vente', 10, 2);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicaments');
    }
};
