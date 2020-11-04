<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItem extends Migration
{
    protected $table = "items";
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
                $table->integer('id_category')->unsigned();
                $table->integer('id_supplier')->unsigned();
                $table->string('name');
                $table->string('image')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('id_category')->references('id')->on('item_category')
                        ->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_client')->references('id')->on('clients')
                        ->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_supplier')->references('id')->on('suppliers')
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
