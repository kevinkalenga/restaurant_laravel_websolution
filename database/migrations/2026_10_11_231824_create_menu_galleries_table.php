<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_galleries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')
                ->constrained('catering_menus')
                ->cascadeOnDelete();

            $table->string('image');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_galleries');
    }
};
