<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter le rôle employe aux rôles existants
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('user', 'admin', 'employe')
            NOT NULL DEFAULT 'user'
        ");

        // Ajouter le statut du compte
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        // Convertir les employés en utilisateurs avant de retirer leur rôle
        DB::table('users')
            ->where('role', 'employe')
            ->update(['role' => 'user']);

        // Supprimer le statut du compte
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        // Restaurer les rôles d'origine
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('user', 'admin')
            NOT NULL DEFAULT 'user'
        ");
    }
};
