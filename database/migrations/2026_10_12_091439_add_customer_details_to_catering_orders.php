
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('catering_first_name')->nullable();
            $table->string('catering_last_name')->nullable();
            $table->string('catering_email')->nullable();
            $table->string('catering_phone')->nullable();
            $table->string('service_location')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'catering_first_name',
                'catering_last_name',
                'catering_email',
                'catering_phone',
                'service_location',
            ]);
        });
    }
};
