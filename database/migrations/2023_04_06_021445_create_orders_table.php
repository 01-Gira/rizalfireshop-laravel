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
            $table->string('order_id');
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('courier');  
            $table->string('courier_service');
            $table->string('address');
            $table->string('message')->nullable();
            $table->integer('weight');
            $table->bigInteger('total_price');
            $table->string('transaction_status')->nullable();
            $table->string('status_code')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('status');
            $table->timestamps();
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
