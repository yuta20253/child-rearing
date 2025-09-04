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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipality_id')->nullable()->constrained()->cascadeOnDelete();

            $table->char('postal_code', 7)->nullable();   // 郵便番号 (ハイフン無し)
            $table->string('town', 100)->nullable();      // 町域 (例: 道玄坂)
            $table->string('chome', 20)->nullable();      // 丁目
            $table->string('banchi', 20)->nullable();     // 番地
            $table->string('go', 20)->nullable();         // 号
            $table->string('building', 100)->nullable();  // 建物名
            $table->string('room', 50)->nullable();       // 部屋番号
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
