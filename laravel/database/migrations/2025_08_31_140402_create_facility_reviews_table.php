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
        Schema::create('facility_reviews', function (Blueprint $table) {
            $table->id()->comment('レビューID');
            $table->foreignId('facility_id')
                  ->constrained('facilities')
                  ->onDelete('cascade')
                  ->comment('施設ID');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('ユーザーID');
            $table->unsignedTinyInteger('rating')->default(3)->comment('評価スコア (1〜5)');
            $table->text('comment')->nullable()->comment('コメント（任意）');
            $table->string('status', 50)->nullable()->comment('ステータス（公開/非公開/保留');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_reviews');
    }
};
