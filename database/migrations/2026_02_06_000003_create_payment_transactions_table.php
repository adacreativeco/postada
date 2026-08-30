<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payment_transactions')) {
            Schema::create('payment_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('package_id')->nullable();
                $table->string('order_id')->unique();
                $table->decimal('amount', 8, 2);
                $table->string('currency')->default('TRY');
                $table->string('status')->default('pending'); // pending, success, failed
                $table->integer('credits_added')->default(0);
                $table->string('payment_method')->default('shopier');
                $table->json('raw_response')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
