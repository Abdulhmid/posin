<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableModules extends Migration
{
    protected $table = "modules"; 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {

                /** Primary key  */
                $table->engine = 'InnoDB';
                $table->increments('module_id');

                /** Main data  */
                $table->string('module_name');
                $table->string('module_name_alias');
                $table->string('module_db')->nullable();
                $table->text('function')->nullable();
                $table->text('function_alias')->nullable();
                $table->string('description');
                $table->integer('id_client')->unsigned();
                $table->string('created_by')->default("system");

                /* Action */
                $table->timestamps();
                $table->softDeletes();
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
    public function down() {
         Schema::dropIfExists($this->table);
    }
}
