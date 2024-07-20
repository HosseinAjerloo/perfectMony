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
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('amount')->nullable();
            $table->enum('type',['deposit','withdrawal'])->nullable();
            $table->bigInteger('creadit_balance')->default(0);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_transactions');
    }
};
