<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->enum('status', ['PENDING', 'BANK_PROCESSING', 'PAID', 'FAILED', 'CANCELLED']);
            $table->decimal('value', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('interest', 10, 2);
            $table->decimal('fine', 10, 2);
            $table->string('identificationField');
            $table->date('dueDate');
            $table->date('scheduleDate');
            $table->date('paymentDate');
            $table->decimal('fee', 10, 2);
            $table->text('description')->nullable();
            $table->string('companyName');
            $table->string('transactionReceiptUrl');
            $table->boolean('canBeCancelled');
            $table->string('failReasons')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
