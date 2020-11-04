<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItemStocks extends Migration
{
    protected $table = "item_stocks";
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
                $table->integer('id_item')->unsigned();
                $table->integer('id_outlet')->unsigned();
                $table->integer('stok');
                $table->timestamps();

                $table->foreign('id_item')->references('id')->on('items')
                        ->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_outlet')->references('id')->on('outlets')
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
