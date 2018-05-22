<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('secondary_phone')->nullable();
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('shortname')->nullable();
            $table->unsignedTinyInteger('boxes');
            $table->string('color', 7)->default('#FFFFFF');
            $table->string('image')->nullable();
            $table->boolean('main')->default(false);
            $table->unsignedInteger('commune_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('commune_id')
                ->references('id')
                ->on('communes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
