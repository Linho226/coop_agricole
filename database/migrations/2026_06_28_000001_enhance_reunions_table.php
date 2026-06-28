<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reunions', function (Blueprint $table) {
            $table->enum('type_reunion', ['ordinaire', 'extraordinaire', 'assemblee_generale', 'financiere', 'production'])
                ->default('ordinaire')
                ->after('titre');
            $table->text('decisions')->nullable()->after('compte_rendu');
            $table->text('actions_suivi')->nullable()->after('decisions');
        });
    }

    public function down(): void
    {
        Schema::table('reunions', function (Blueprint $table) {
            $table->dropColumn(['type_reunion', 'decisions', 'actions_suivi']);
        });
    }
};
