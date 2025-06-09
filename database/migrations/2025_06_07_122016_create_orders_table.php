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
            $table->string('InvoiceNumber', 50)->unique()->nullable();
            $table->string('CustomerName');
            $table->text('Address');
            $table->string('Phone', 32)->nullable();
            $table->dateTime('BookingDate');
            $table->string('Product');
            $table->integer('Quantity');
            $table->bigInteger('TotalPrice');
            $table->enum('OrderStatus', ['Waiting Approval', 'Approved', 'Rejected']);
            $table->enum('PaymentStatus', ['Unpaid', 'Paid', 'Failed']);
            $table->dateTime('CreatedDate')->useCurrent();
            $table->string('CreatedBy', 32);
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
        Schema::dropIfExists('orders');
    }
};
