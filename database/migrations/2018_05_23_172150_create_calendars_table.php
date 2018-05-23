<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->text('notes')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('service_id');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');

            $table->foreign('status_id')
                ->references('id')
                ->on('calendar_statuses');

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');

            $table->foreign('service_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
