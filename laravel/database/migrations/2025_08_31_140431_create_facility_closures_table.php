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
        Schema::create('facility_closures', function (Blueprint $table) {
            $table->id()->comment('休業情報ID');
            $table->foreignId('facility_id')
                  ->constrained('facilities')
                  ->onDelete('cascade')
                  ->comment('施設ID');
            $table->date('closed_date')->comment('休館日');
            $table->text('reason')->nullable()->comment('理由（任意）');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_closures');
    }
};
