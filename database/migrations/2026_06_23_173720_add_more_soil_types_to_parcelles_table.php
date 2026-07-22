<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier l'enum type_sol pour ajouter hydromorphe et sale
        DB::statement("ALTER TABLE parcelles MODIFY COLUMN type_sol ENUM(
            'argileux','sableux','limoneux','lateritique','ferrugineux','hydromorphe','sale'
        ) NOT NULL");
    }

    public function down(): void
    {
        // Revenir à l'ancienne version
        DB::statement("ALTER TABLE parcelles MODIFY COLUMN type_sol ENUM(
            'argileux','sableux','limoneux','lateritique','ferrugineux'
        ) NOT NULL");
    }
};