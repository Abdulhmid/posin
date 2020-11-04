<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAdditionalInfoInTransactions extends Migration
{
    protected $table = "transactions";
    protected $column = "additional_info";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasColumn($this->table, $this->column)){
            Schema::table($this->table, function (Blueprint $table) {
                $table->text($this->column)->nullable();
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
        if(Schema::hasColumn($this->table, $this->column)){
            Schema::table($this->table, function (Blueprint $table) {
                Schema::table($this->table, function (Blueprint $table) {
                   $table->dropColumn($this->column);
                });
            });
        }
    }
}
