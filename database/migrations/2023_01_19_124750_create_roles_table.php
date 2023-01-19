<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('roles', function (Blueprint $table) {$table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });
        DB::table('roles')->insert([
            [ 'name' => 'Operations Manager'],
            [ 'name' => 'Secretary'],
            [ 'name' => 'Project Leader'],
            [ 'name' => 'Secretary'],
            [ 'name' => 'Sales Consultant'],
            [ 'name' => 'Support'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
