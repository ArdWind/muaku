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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id(); // id utama
            $table->string('name'); // nama item galeri
            $table->enum('category', ['WEDDING', 'BRIDESMAID', 'ENGAGEMENT DAY', 'GRADUATION']);
            $table->string('image_path'); // URL dari MinIO
            $table->tinyInteger('Status')->default(1);
            $table->dateTime('CreatedDate')->useCurrent();
            $table->string('CreatedBy', 32)->default('system');
            $table->dateTime('LastUpdatedDate')->nullable();
            $table->string('LastUpdatedBy', 32)->nullable();
            $table->string('CompanyCode', 20)->default('1');
            $table->tinyInteger('IsDeleted')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
