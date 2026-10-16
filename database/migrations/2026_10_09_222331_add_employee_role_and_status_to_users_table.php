<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL nécessite cette modification pour ajouter le rôle employé.
        // SQLite utilise un type compatible sans cette instruction.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE users
                MODIFY role ENUM('user', 'admin', 'employe')
                NOT NULL DEFAULT 'user'
            ");
        }

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        DB::table('users')
            ->where('role', 'employe')
            ->update(['role' => 'user']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE users
                MODIFY role ENUM('user', 'admin')
                NOT NULL DEFAULT 'user'
            ");
        }
    }
};
