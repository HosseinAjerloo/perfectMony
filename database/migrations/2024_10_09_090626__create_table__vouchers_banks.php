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
        Schema::create('vouchers_bank', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->string('code')->nullable();
            $table->string('amount')->nullable();
            $table->enum('status',['used','new'])->nullable();
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
        Schema::dropIfExists('voochers_bank');
    }
};
