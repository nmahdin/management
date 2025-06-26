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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('property')->default(0);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('partner_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('order_id')->nullable(); // اگر خواستید ارجاع به سفارش داشته باشد
            $table->unsignedBigInteger('product_id')->nullable();
            $table->bigInteger('amount'); // مبلغ
            $table->string('type'); // 'debt' بدهی به شریک (طلب شریک)، 'settlement' تسویه شده
            $table->string('description')->nullable();
            $table->dateTime('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
        Schema::dropIfExists('partner_transactions');
    }
};
