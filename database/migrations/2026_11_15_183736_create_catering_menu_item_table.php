
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catering_menu_item', function (Blueprint $table) {
            $table->id();

            $table->foreignId('catering_menu_id')
                ->constrained('catering_menus')
                ->cascadeOnDelete();

            $table->foreignId('menu_item_id')
                ->constrained('catering_menu_items')
                ->cascadeOnDelete();

            $table->unsignedInteger('quantity')->default(1);

            $table->timestamps();

            $table->unique([
                'catering_menu_id',
                'menu_item_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_menu_item');
    }
};
