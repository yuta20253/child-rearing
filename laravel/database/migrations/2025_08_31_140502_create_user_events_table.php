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
        Schema::create('user_events', function (Blueprint $table) {
            $table->id()->comment('ユーザー予定ID');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('ユーザーID');
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade')
                  ->comment('イベントID');
            $table->text('memo')->nullable()->comment('ユーザーが入力するメモ');

            $table->softDeletes()->comment('論理削除日時');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_events');
    }
};
