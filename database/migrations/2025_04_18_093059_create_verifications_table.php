<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Constraint\Constraint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('unique_id');
            $table->string('otp');
            $table->enum('type', ['register', 'reset_password']);
            $table->enum('send_via', ['email', 'sms', 'wa']);
            $table->integer('resend')->default(0);
            $table->enum('Status', ['active', 'valid', 'invalid']);
            $table->dateTime('CreatedDate')->useCurrent(); // default: now()
            $table->dateTime('LastUpdatedDate')->nullable();
            $table->string('CompanyCode', 20)->nullable();
            $table->tinyInteger('IsDeleted')->nullable();
            $table->string('CreatedBy', 32)->default('system');
            $table->string('LastUpdatedBy', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};
