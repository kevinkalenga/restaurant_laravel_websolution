
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_product', function (Blueprint $table) {
            $table->enum('dish_type', [
                'entree',
                'plat',
                'dessert',
            ])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('menu_product', function (Blueprint $table) {
            $table->enum('dish_type', [
                'entree',
                'plat',
                'dessert',
            ])->nullable(false)->change();
        });
    }
};
