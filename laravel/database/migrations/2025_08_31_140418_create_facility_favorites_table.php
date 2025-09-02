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
        Schema::create('facility_favorites', function (Blueprint $table) {
            $table->id()->comment('お気に入り施設ID');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('ユーザーID');
            $table->foreignId('facility_id')
                  ->constrained('facility_favorites')
                  ->onDelete('cascade')
                  ->comment('お気に入り施設');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_favorites');
    }
};
