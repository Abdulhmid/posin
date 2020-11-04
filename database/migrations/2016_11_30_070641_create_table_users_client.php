<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersClient extends Migration
{
    protected $table = "users";
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
                $table->string('username');
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->integer('id_role')->unsigned();
                $table->integer('id_client')->unsigned();
                $table->integer('id_outlet')->unsigned();
                $table->text('address')->nullable();
                $table->string('photo')->nullable();
                $table->timestamps();

                $table->foreign('id_role')->references('id')->on('roles_client')
                        ->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_outlet')->references('id')->on('outlets')
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
