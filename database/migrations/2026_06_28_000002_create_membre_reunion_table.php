<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membre_reunion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reunion_id')->constrained('reunions')->cascadeOnDelete();
            $table->foreignId('membre_id')->constrained('membres')->cascadeOnDelete();
            $table->boolean('present')->default(true);
            $table->timestamps();

            $table->unique(['reunion_id', 'membre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membre_reunion');
    }
};
