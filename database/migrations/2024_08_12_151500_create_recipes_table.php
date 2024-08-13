<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Recipe;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', Recipe::TYPES);
            $table->enum('difficulty', Recipe::DIFFICULTIES);
            $table->string('title', 120);
            $table->string('slug')->unique();
            $table->string('thumb_url')->comment('400x400');
            $table->string('banner_url')->comment('1600x524');
            $table->string('time_str', 12);
            $table->string('portions_str', 12);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
