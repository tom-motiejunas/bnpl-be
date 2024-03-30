<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_loans', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_id');
            $table->string('payment_method_id');
            $table->dateTime('last_payment');
            $table->dateTime('next_payment');
            $table->float('total');
            $table->float('total_paid');
            $table->integer('instalment');
            $table->integer('total_instalment');
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_loans');
    }
};
