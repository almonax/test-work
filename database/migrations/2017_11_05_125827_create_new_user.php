<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateNewUser extends Migration
{
    private $tableName = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table($this->tableName)->insert([
            'name' => 'Admin',
            'email' => 'admin@domain.loc',
            'password' => '$2y$10$rgUc3E0Y5GfxwQh3FGHb1u7Ee9sgba2IE/TFSAkvc4sBLHnx/S1ty'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table($this->tableName)->truncate();
    }
}
