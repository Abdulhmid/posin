<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {

                $table->engine = 'InnoDB';
                /** Primary key  */
                $table->increments('city_id');

                /** Main data  */
                $table->integer('state_id')->unsigned();
                $table->string('name');


                /** Action */
                $table->nullableTimestamps();
                /** Foreign Key */
                $table->foreign('state_id')->references('state_id')->on('states')
                     ->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cities');
    }
}
