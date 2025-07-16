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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_plan_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique();
            $table->double('price');
            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending'); // pending, success, failed, cancelled
            $table->string('payment_url')->nullable();
            $table->json('payload')->nullable(); // Response dari Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
