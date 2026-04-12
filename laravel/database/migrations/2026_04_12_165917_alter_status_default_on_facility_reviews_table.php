<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE facility_reviews MODIFY status ENUM('公開','非公開','保留') DEFAULT '公開'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE facility_reviews MODIFY status ENUM('公開','非公開','保留') DEFAULT '保留'");
    }
};
