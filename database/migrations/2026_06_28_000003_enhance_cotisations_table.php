<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->string('reference')->nullable()->unique();
            $table->enum('type_cotisation', ['mensuelle', 'annuelle', 'adhesion', 'penalite', 'contribution_speciale'])
                ->default('mensuelle');
            $table->unsignedTinyInteger('periode_mois')->nullable();
            $table->unsignedSmallInteger('periode_annee')->nullable();
            $table->decimal('montant_attendu', 12, 2)->default(0);
            $table->enum('statut', ['paye', 'partiel', 'annule'])->default('paye');
        });
    }

    public function down(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->dropUnique(['reference']);
            $table->dropColumn([
                'reference',
                'type_cotisation',
                'periode_mois',
                'periode_annee',
                'montant_attendu',
                'statut',
            ]);
        });
    }
};
