
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('catering_menu_id')
                ->nullable()
                ->constrained('catering_menus')
                ->nullOnDelete();

            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->unsignedInteger('number_of_persons')->nullable();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')
                ->nullable(false)
                ->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['catering_menu_id']);
            $table->dropColumn([
                'catering_menu_id',
                'delivery_date',
                'delivery_time',
                'number_of_persons',
            ]);
        });
    }
};
