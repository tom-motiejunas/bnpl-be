<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_loans', static function (Blueprint $table) {
            $table->foreignId('shop_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('user_loans', static function (Blueprint $table) {
            $table->dropColumn('shop_id');
        });
    }
};
