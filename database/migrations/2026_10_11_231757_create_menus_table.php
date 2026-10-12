<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catering_menus', function (Blueprint $table) {
            $table->id();

            // Informations générales
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            // Prix et nombre minimum de personnes
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('minimum_persons')->default(1);

            // Classification
            $table->string('theme')->default('classique');
            $table->string('diet')->default('classique');

            // Stock disponible
            $table->unsignedInteger('available_stock')->default(0);

            // Conditions de commande et de conservation
            $table->unsignedInteger('advance_notice_hours')->default(24);
            $table->text('storage_conditions')->nullable();
            $table->text('order_conditions')->nullable();

            // Visibilité
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_menus');
    }
};
