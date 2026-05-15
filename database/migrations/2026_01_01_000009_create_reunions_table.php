<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->date('date_reunion');
            $table->time('heure')->nullable();
            $table->string('lieu')->nullable();
            $table->text('ordre_du_jour')->nullable();
            $table->text('compte_rendu')->nullable();
            $table->enum('statut', ['planifie', 'tenu', 'annule'])->default('planifie');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};
