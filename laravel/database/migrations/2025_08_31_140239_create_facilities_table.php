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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id()->comment('施設ID');
            $table->string('name')->comment('施設名');
            $table->string('address')->comment('住所');
            $table->decimal('latitude', 10, 7)->comment('緯度');
            $table->decimal('longitude', 10, 7)->comment('経度');
            $table->text('equipment')->comment('設備情報');
            $table->text('description')->comment('概要');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
