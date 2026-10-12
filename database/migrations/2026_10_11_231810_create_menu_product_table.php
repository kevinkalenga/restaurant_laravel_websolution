<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')
                ->constrained('catering_menus')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->enum('dish_type', [
                'entree',
                'plat',
                'dessert',
            ]);

            $table->unsignedInteger('quantity')->default(1);

            $table->timestamps();

            $table->unique(['menu_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_product');
    }
};
