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
        Schema::create('house_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spender_id');
            $table->string('expense_name');
            $table->integer('amount');
            $table->string('house_name');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_expenses');
    }
};