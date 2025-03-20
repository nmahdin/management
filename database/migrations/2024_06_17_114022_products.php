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

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('name');
            $table->string('color');

            $table->unsignedBigInteger('category_id'); // دسته بندی
//            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('picture')->nullable();
            $table->string('partner_id'); // مالک
//            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->string('price_materials'); // قیمت مواد اولیه
            $table->string('salary')->default(0); // دسمزد
            $table->string('profit')->default(0); // سود
            $table->string('materials_profit')->default(0); // سود مواد اولیه
            $table->string('additional_costs')->default(0); // هزینه های دیگر
            $table->string('total_price'); // قیمت تمام شده محصول
            $table->string('inventory'); // موجودی
            $table->unsignedBigInteger('status_id');
            $table->string('label')->nullable(); // برچسب
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // نام
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('statuses');
    }
};
