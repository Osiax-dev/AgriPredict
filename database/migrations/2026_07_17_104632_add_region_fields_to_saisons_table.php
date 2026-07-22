<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saisons', function (Blueprint $table) {
            $table->foreignId('parcelle_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            $table->string('region')->nullable()->after('culture');       // 'nord' ou 'sud'
            $table->string('type_saison')->nullable()->after('region');   // saison_pluies, grande_saison_pluies, etc.
            $table->string('campagne')->nullable()->after('type_saison'); // 1ere_campagne, 2eme_campagne, unique
            $table->boolean('pluies_confirmees')->nullable()->after('campagne');
            $table->decimal('cumul_pluies_mm', 6, 2)->nullable()->after('pluies_confirmees');
        });
    }

    public function down(): void
    {
        Schema::table('saisons', function (Blueprint $table) {
            $table->dropForeign(['parcelle_id']);
            $table->dropColumn([
                'parcelle_id', 'region', 'type_saison', 'campagne',
                'pluies_confirmees', 'cumul_pluies_mm'
            ]);
        });
    }
};