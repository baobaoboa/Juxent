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
        Schema::create('warranties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('created_by');
            $table->char('product_id');
            $table->double('amount_paid');
            $table->date('date_paid');
            $table->string('official_receipt');
            $table->string('warranty');
            $table->string('acknowledgement_receipt');
            //$table->string('record_status');
            $table->date('starting_date_of_warranty_availed');
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
        Schema::dropIfExists('warranties');
    }
};
