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
        Schema::create('facility_hours', function (Blueprint $table) {
            $table->id()->comment('営業時間ID');
            $table->foreignId('facility_id')
                  ->constrained('facilities')
                  ->onDelete('cascade')
                  ->comment('施設ID');
            $table->unsignedTinyInteger('day_of_week')
                  ->comment('曜日 (0=日曜 ～ 6=土曜)');
            $table->time('open_time')->nullable()->comment('開始時刻');
            $table->time('close_time')->nullable()->comment('終了時刻');
            $table->string('note', 255)->nullable()->comment('備考 (祝日営業など)');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_hours');
    }
};
