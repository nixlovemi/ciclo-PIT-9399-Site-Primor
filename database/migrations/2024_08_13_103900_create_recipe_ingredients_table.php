<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\RecipeIngredients;

class CreateRecipeIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')
                ->constrained('recipes')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('quantity', 15)->nullable();
            $table->string('description', 80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE recipe_ingredients DROP FOREIGN KEY recipe_ingredients_recipe_id_foreign;
        ");
        Schema::dropIfExists('recipe_ingredients');
    }
}
