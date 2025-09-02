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
        Schema::table('facility_reviews', function (Blueprint $table) {
            $table->enum('status', ['公開', '非公開', '保留'])
                  ->default('保留')
                  ->comment('ステータス')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facility_reviews', function (Blueprint $table) {
            $table->string('status', 50)->nullable()->comment('ステータス（公開/非公開/保留')->change();
        });
    }
};
