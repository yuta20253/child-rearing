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
        Schema::create('events', function (Blueprint $table) {
            $table->id()->comment('イベントID');
            $table->foreignId('facility_id')
                  ->constrained('facilities')
                  ->onDelete('cascade')
                  ->comment('施設ID');
            $table->string('title')->comment('イベント名');
            $table->text('description')->nullable()->comment('内容');
            $table->dateTime('start_datetime')->nullable()->comment('開始日時');
            $table->dateTime('end_datetime')->nullable()->comment('終了日時');
            $table->unsignedInteger('capacity')->nullable()->comment('定員（任意）');

            $table->softDeletes()->comment('論理削除日時');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
