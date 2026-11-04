<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('theme')->default('classique');
            $table->string('diet')->default('classique');
            $table->unsignedInteger('advance_notice_hours')->default(24);
            $table->text('storage_conditions')->nullable();
            $table->text('order_conditions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'theme',
                'diet',
                'advance_notice_hours',
                'available_stock',
                'storage_conditions',
                'order_conditions',
            ]);
        });
    }
};
