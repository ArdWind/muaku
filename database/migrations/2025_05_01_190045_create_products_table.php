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
            $table->string('product_code');
            $table->string('product_name');
            $table->text('description')->nullable(); // deskripsi produk
            $table->string('product_img')->nullable(); // path gambar : asset/product_img/nama_file.jpg)
            $table->decimal('price', 15); // untuk harga
            $table->decimal('discount', 5)->default(0); // diskon dalam persen (contoh: 10.50)
            $table->tinyInteger('Status')->nullable();
            $table->dateTime('CreatedDate')->useCurrent(); // default: now()
            $table->string('CreatedBy', 32)->default('system');
            $table->dateTime('LastUpdatedDate')->nullable();
            $table->string('LastUpdatedBy', 32)->nullable();
            $table->string('CompanyCode', 20)->default('1');
            $table->tinyInteger('IsDeleted')->default('1');
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
