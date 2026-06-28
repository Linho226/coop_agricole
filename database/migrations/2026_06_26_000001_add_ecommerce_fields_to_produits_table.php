<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->decimal('prix_unitaire', 12, 2)->default(0)->after('unite');
            $table->decimal('stock_disponible', 12, 3)->default(0)->after('prix_unitaire');
            $table->boolean('publie')->default(true)->after('stock_disponible');
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn(['prix_unitaire', 'stock_disponible', 'publie']);
        });
    }
};
