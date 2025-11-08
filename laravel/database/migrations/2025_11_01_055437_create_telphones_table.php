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
        Schema::create('telphones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->comment('施設ID');
            $table->string('number', 11)->comment('電話番号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telphones');
    }
};
