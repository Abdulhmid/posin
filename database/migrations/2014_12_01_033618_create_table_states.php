<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('states')) {
            Schema::create('states', function (Blueprint $table) {

                $table->engine = 'InnoDB';
                /** Primary key  */
                $table->increments('state_id');

                /** Main data  */
                $table->string('country');
                $table->string('name');
                $table->text('description')->nullable();
                /** Foreign Key */

                /** Action */
                $table->nullableTimestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('states');
    }
}
