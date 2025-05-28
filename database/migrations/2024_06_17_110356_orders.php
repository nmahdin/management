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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('customer_id');
        $table->foreign('customer_id')->references('id')->on('customers');
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users');
        $table->string('date');
        $table->string('amount');
        $table->string('tax')->nullable(); // مالیات
        $table->string('extra_expenses')->nullable(); // هزینه های اضافی
        $table->string('services')->nullable(); // خدمات
        $table->string('profit'); // سود
        $table->string('discount')->default(0); // تخفیف
        $table->integer('transportation_price')->default(0);
        $table->string('status');
        $table->string('type_id'); // فروش نمایشگاهی و ...
        $table->softDeletes();
        $table->text('note')->nullable();
        $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->bigInteger('unit_price');
            $table->bigInteger('total_price');
            $table->primary(['order_id' , 'product_id']);
        });

        Schema::create('customer_order', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_id');
            $table->primary(['customer_id' , 'order_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('customer_order');
        Schema::dropIfExists('orders');
    }
};
