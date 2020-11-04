<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionsDetail extends Migration
{
    protected $table = "transactions_detail";
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
                $table->string('id_trans');
                $table->integer('id_item')->unsigned();
                $table->integer('qty');
                $table->decimal('amount', 18, 2);
                $table->decimal('discount', 18, 2);
                $table->timestamps();

                $table->foreign('id_trans')->references('id_trans')->on('transactions')
                        ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_item')->references('id')->on('items')
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
