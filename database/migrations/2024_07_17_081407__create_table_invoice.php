<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('service_id_custom')->nullable()->comment('در صورتی پر میشود که کاربر بخواهد از سرویس سفارشی استفاده کند');
            $table->foreignId('disscount_code_id')->nullable()->constrained('disscount_codes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->bigInteger('final_amount')->nullable();
            $table->integer('time_price_of_dollars')->nullable();
            $table->enum('type', ['service', 'wallet'])->nullable();
            $table->enum('status',['requested','failed','finished'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
