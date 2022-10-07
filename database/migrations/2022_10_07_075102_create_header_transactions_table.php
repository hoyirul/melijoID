<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_transactions', function (Blueprint $table) {
            $table->string('txid')->primary();
            $table->foreignId('user_customer_id')->constrained();
            $table->foreignId('user_seller_id')->constrained();
            $table->foreignId('user_operator_id')->constrained();
            $table->timestamp('date_order')->nullable();
            $table->float('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('header_transactions');
    }
};
