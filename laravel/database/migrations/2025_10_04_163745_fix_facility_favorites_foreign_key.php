<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facility_favorites', function (Blueprint $table) {
            $table->dropForeign(['facility_id']);

            $table->foreign('facility_id')
                  ->references('id')
                  ->on('facilities')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('facility_favorites', function (Blueprint $table) {
            $table->dropForeign(['facility_id']);

            // 間違った定義を再登録（通常は不要だけど、downメソッドを整えるために残す）
            $table->foreign('facility_id')
                  ->references('id')
                  ->on('facility_favorites')
                  ->onDelete('cascade');
        });
    }
};
