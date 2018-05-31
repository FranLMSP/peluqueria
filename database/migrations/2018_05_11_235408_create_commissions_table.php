<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('percentage');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('employee_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_id')->references('id')->on('product_headers')
                ->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commissions', function($table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['employee_id']);
        });
        Schema::dropIfExists('commissions');
    }
}
