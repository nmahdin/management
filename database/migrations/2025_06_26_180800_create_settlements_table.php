<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('user_id')->nullable(); // کاربر ثبت‌کننده
            $table->unsignedBigInteger('order_id')->nullable(); // در صورت ارتباط با سفارش
            $table->bigInteger('amount');
            $table->enum('type', ['debt', 'settlement']); // بدهی یا پرداخت
            $table->string('method')->nullable(); // نوع پرداخت: نقدی، کارت، حواله و...
            $table->string('reference')->nullable(); // شماره پیگیری یا سند
            $table->text('description')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('partner_id')->references('id')->on('partners');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};
