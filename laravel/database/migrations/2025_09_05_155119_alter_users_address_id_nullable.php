<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 既存の外部キーを削除
            $table->dropForeign(['address_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            // address_id を NULL 許容に変更
            $table->unsignedBigInteger('address_id')->nullable()->change();

            // 外部キー制約を追加
            $table->foreign('address_id')
                  ->references('id')
                  ->on('addresses')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->unsignedBigInteger('address_id')->nullable(false)->change();
            $table->foreign('address_id')
                  ->references('id')
                  ->on('addresses');
        });
    }
};
