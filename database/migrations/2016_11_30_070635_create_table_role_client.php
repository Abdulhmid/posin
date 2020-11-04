<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRoleClient extends Migration
{
    protected $table = "roles_client";
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
                $table->integer('id_role')->unsigned();
                $table->integer('id_client')->nullable()->unsigned();
                $table->timestamps();

                $table->foreign('id_role')->references('id')->on('roles')
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
