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
        Schema::table('facility_favorites', function (Blueprint $table) {
            $table->dropForeign(['facility_id']);

            $table->dropColumn('deleted_at');

            $table->unique(['user_id', 'facility_id']);

            $table->unsignedBigInteger('facility_id')
                  ->comment('施設ID')
                  ->change();

            $table->foreign('facility_id')
                  ->references('id')
                  ->on('facilities')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facility_favorites', function (Blueprint $table) {
            $table->dropForeign(['facility_id']);

            $table->dropUnique(['facility_favorites_user_id_facility_id_unique']);

            $table->unsignedBigInteger('facility_id')
                ->comment('お気に入り施設')
                ->change();

            $table->softDeletes();

            $table->foreign('facility_id')
                  ->references('id')
                  ->on('facility_favorites');
        });
    }
};
