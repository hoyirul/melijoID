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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('txid', 20)->nullable();
            $table->foreign('txid')->references('txid')->on('header_transactions');
            $table->string('invoice', 20)->unique();
            $table->text('evidence_of_transfer')->nullable();
            $table->timestamp('paid_date')->nullable();
            $table->float('pay')->nullable();
            $table->enum('status', ['unpaid', 'processing', 'paid'])->default('unpaid');
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
        Schema::dropIfExists('payments');
    }
};
