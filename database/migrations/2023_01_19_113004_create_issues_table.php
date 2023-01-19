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
        Schema::create('issues', function (Blueprint $table) {
            $table->uuid('id');
            $table->char('client_id');
            $table->char('sale_id');
            $table->char('support_id');
            $table->date('date_accommodation');
            $table->string('reported_issue');
            $table->string('status');
            $table->string('work_type');
            $table->string('findings_service');
            $table->string('recommend_status');
            $table->double('fee');
            $table->double('charge');
            $table->string('time_allotted');
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
        Schema::dropIfExists('issues');
    }
};
