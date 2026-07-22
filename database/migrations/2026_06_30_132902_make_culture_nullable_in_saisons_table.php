<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saisons', function (Blueprint $table) {
            $table->string('culture')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('saisons', function (Blueprint $table) {
            $table->string('culture')->nullable(false)->change();
        });
    }
};