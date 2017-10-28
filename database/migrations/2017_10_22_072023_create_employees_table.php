<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function(Blueprint $table) {
            # set engine
            $table->engine = 'InnoDB';
            # basic columns
            $table->increments('id');
            $table->string('fullname', 50);
            # for build tree
            $table->integer('lft');
            $table->integer('rht');
            $table->mediumInteger('lvl', false, true);
            # other data
            $table->decimal('salary', 11, 2)->nullable();
            $table->date('beg_work')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
