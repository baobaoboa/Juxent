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
            $table->id();
            $table->char('client_id');
            $table->date('date_of_purchase');
            $table->double('amount_paid');
            $table->date('date_paid');
            $table->string('official_receipt');
            $table->string('acknowledgement_receipt');
            $table->date('date_delivered');
            $table->string('record_status');
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
