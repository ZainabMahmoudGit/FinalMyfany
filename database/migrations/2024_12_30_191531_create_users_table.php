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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('mobile')->unique();
            $table->string('otp')->nullable();
            $table->boolean('otp_verified')->default(false); // إضافة حالة التحقق
            $table->string('password')->nullable(); // إضافة حقل كلمة المرور
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
