<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('lat', 10, 8)->after('service_time');
            $table->decimal('lng', 11, 8)->after('lat');
        });
    }
    
    public function down() {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lng']);
        });
    }
    
};
