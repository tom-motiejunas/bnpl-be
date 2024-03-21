<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('api_key');
            $table->string('domain');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop');
    }
};
