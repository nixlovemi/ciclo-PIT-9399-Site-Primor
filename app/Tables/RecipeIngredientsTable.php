<?php

namespace App\Tables;

use App\Models\RecipeIngredient;
use App\Models\Recipe;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\Formatters\DateFormatter;
use Okipa\LaravelTable\RowActions\DestroyRowAction;
use Okipa\LaravelTable\RowActions\EditRowAction;
use Okipa\LaravelTable\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Tables\HeadActions\OpenModalHeadAction;

class RecipeIngredientsTable extends AbstractTableConfiguration
{
    public int $recipeID;
    private Recipe $Recipe;
    public bool $readOnly = true;

    protected function table(): Table
    {
        $this->init();

        return Table::make()->model(RecipeIngredient::class)
            ->numberOfRowsPerPageOptions([50])
            ->query(function(Builder $query) {
                return $query
                    ->where('recipe_id', '=', $this->recipeID ?? 0)
                    ->orderBy('id', 'ASC');
            })
            ->headAction(
                $this->addHeadAction()->when($this->readOnly === false)
            )
            ->rowActions(fn(RecipeIngredient $recipeIngredient) => [
                (new DestroyRowAction())
                    ->feedbackMessage('O ingrediente foi removido com sucesso.')
                    ->when($this->readOnly === false),
            ]);
    }

    protected function columns(): array
    {
        return [
            Column::make('quantity')->title('Quantidade'),
            Column::make('description')->title('Ingrediente'),
        ];
    }

    private function init(): void
    {
        $this->Recipe = Recipe::where('id', '=', $this->recipeID)->first();
    }

    private function addHeadAction(): OpenModalHeadAction
    {
        return new OpenModalHeadAction(
            route('admin.receitas.addIngredient',
            ['recipeCodedId' => $this->Recipe->codedId, 'json' => true]),
            'Adicionar',
            '<i class="fas fa-plus"></i>',
            [],
            ['btn', 'btn-primary', 'btn-sm']
        );
    }
}
