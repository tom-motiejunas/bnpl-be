<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_loan', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('purchase_id');
            $table->dateTime('last_payment')->nullable();
            $table->dateTime('next_payment');
            $table->integer('amount');
            $table->integer('total_paid');
            $table->integer('instalment');
            $table->integer('total_instalments');
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_loan');
    }
};
