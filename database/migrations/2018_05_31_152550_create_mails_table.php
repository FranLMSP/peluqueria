<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->string('email');
            $table->text('message');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('status_id');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->references('id')
                ->on('mail_statuses')
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
        Schema::table('mails', function($table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['status_id']);
        });
        Schema::dropIfExists('mails');
    }
}
