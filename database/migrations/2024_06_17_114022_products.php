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
            $table->unsignedBigInteger('partner_id'); // مالک
//            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->string('price_materials'); // قیمت مواد اولیه
            $table->string('salary')->nullable(); // دسمزد
            $table->string('profit')->nullable(); // سود
            $table->string('total_price'); // قیمت تمام شده محصول
            $table->string('inventory'); // موجودی
            $table->string('label')->nullable(); // برچسب
            $table->string('notes')->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
