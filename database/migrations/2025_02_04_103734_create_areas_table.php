<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    
        DB::table('areas')->insert([
            ['name' => 'حولي', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'السالمية', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الفروانية', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    
    
};
