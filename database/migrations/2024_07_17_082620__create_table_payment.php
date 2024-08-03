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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->nullable()->constrained('banks')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('state',['requested','finished','failed'])->nullable();
            $table->integer('amount')->nullable();
            $table->integer('order_id')->nullable();
            $table->text('RefNum')->nullable();
            $table->text('ResNum')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
