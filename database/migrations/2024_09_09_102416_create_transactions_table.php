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

        Schema::create('transactions_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('notes')->nullable();
            $table->boolean('deleted')->default(0);
            $table->timestamps();
        });


        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('date');
            $table->integer('amount');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('transactions_categories');
            $table->string('status');
            $table->string('reference'); // دلیل یا مرجع
            $table->string('attached'); //پیوست
            $table->text('notes');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_categories');
        Schema::dropIfExists('transactions');
    }
};
