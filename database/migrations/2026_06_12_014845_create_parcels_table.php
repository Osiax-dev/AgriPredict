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
    Schema::create('parcelles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nom');
        $table->decimal('superficie', 8, 2);
        $table->string('culture')->nullable();
        $table->string('type_sol')->nullable();
        $table->decimal('lat', 10, 7);
        $table->decimal('lng', 10, 7);
        $table->decimal('ndvi_actuel', 4, 2)->nullable();
        $table->string('departement')->nullable();
        $table->string('commune')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcelles');
    }
};
