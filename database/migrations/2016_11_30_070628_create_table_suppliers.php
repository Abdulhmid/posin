<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuppliers extends Migration
{
    protected $table = "suppliers";
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
                $table->integer('id_client')->unsigned();
                $table->string('name');
                $table->string('handphone')->nullable();
                $table->string('telp')->nullable();
                $table->string('address');
                $table->integer('city_id')->unsigned();
                $table->text('description');
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
