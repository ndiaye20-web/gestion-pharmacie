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
    Schema::create('ventes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->nullable()->constrained();
        $table->foreignId('pharmacien_id')->nullable();
        $table->decimal('remboursement', 10, 2)->default(0);
        $table->string('mode_paiement')->nullable();
        $table->string('ticket_numero')->nullable();
        $table->dateTime('date');
        $table->timestamps();
        $table->decimal('total', 10, 2);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
