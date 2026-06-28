<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('nom_client');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->text('adresse_livraison');
            $table->string('statut')->default('en_attente');
            $table->decimal('montant_total', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('confirmee_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
