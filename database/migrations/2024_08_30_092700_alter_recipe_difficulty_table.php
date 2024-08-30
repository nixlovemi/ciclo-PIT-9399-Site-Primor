<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterRecipeDifficultyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE recipes MODIFY COLUMN difficulty enum('Fácil','Moderada','Difícil','Muito Difícil') NOT NULL;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE recipes MODIFY COLUMN difficulty enum('Fácil','Moderada','Difícil') NOT NULL;
        ");
    }
}
