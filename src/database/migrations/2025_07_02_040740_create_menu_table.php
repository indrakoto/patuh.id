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
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->unsignedInteger('parent')->nullable();
            $table->string('route', 255)->nullable();
            $table->integer('order')->nullable();
            $table->binary('data')->nullable();

            $table->foreign('parent')
                ->references('id')
                ->on('menu')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->index('parent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropForeign(['parent']);
            $table->dropIndex(['parent']);
        });

        Schema::dropIfExists('menu');
    }
};
