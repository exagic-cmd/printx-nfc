<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('receipts', function (Blueprint $table) {
        $table->id();
        $table->string('gate');
        $table->string('trn');
        $table->date('date');
        $table->time('time');
        $table->string('receipt_number');
        $table->string('owner_name');
        $table->string('vehicle_number');
        $table->decimal('total_amount', 8, 2);
        $table->decimal('research_support', 8, 2);
        $table->decimal('collection_fee', 8, 2);
        $table->decimal('vat', 8, 2);
        $table->string('user_name');
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
        Schema::dropIfExists('receipts');
    }
}
