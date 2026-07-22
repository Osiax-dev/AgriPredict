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
    Schema::create('previsions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('parcelle_id')->constrained()->onDelete('cascade');
        $table->foreignId('saison_id')->constrained()->onDelete('cascade');
        $table->string('culture');
        $table->float('ndvi')->nullable();
        $table->float('temperature')->nullable();
        $table->float('pluviometrie')->nullable();
        $table->float('humidite')->nullable();
        $table->float('rendement_prevu');
        $table->float('production_totale');
        $table->integer('confiance');
        $table->json('top_features')->nullable();
        $table->text('recommandations')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previsions');
    }
};
