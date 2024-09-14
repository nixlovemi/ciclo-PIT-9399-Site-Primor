@inject('mRecipe', 'App\Models\Recipe')

@php
/*
View variables:
===============
    - $RECIPE: App\Models\Recipe
    - $READONLY: bool
*/
@endphp

<div class="row">
    <div class="col">
        <livewire:table
            :config="App\Tables\RecipeIngredientsTable::class"
            :configParams="[
                'recipeID' => $RECIPE?->id ?? 0,
                'readOnly' => $READONLY ?? true,
            ]"
        />
    </div>
</div>