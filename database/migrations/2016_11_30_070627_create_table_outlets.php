<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOutlets extends Migration
{
    protected $table = "outlets";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('handphone', 15);
                $table->string('telp', 15);
                $table->integer('city_id')->unsigned();
                $table->integer('id_client')->unsigned();
                $table->text('address');
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('city_id')->references('city_id')->on('cities')
                        ->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_client')->references('id')->on('clients')
                        ->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
