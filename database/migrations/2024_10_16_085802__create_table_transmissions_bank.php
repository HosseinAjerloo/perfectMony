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
        Schema::create('transmissions_bank', function (Blueprint $table) {
            $table->id();
            $table->string('payment_amount')->nullable();
            $table->string('payment_batch_num')->nullable();
            $table->enum('status',['used','new'])->default('new')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transmissions_bank');
    }
};
