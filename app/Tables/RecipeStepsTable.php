<?php

namespace App\Tables;

use App\Models\RecipeStep;
use App\Models\Recipe;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\RowActions\DestroyRowAction;
use App\Tables\RowActions\OpenModalRowAction;
use Okipa\LaravelTable\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Tables\HeadActions\OpenModalHeadAction;

class RecipeStepsTable extends AbstractTableConfiguration
{
    public int $recipeID;
    private Recipe $Recipe;
    public bool $readOnly = true;

    protected function table(): Table
    {
        $this->init();

        return Table::make()->model(RecipeStep::class)
            ->numberOfRowsPerPageOptions([50])
            ->query(function(Builder $query) {
                return $query
                    ->where('recipe_id', '=', $this->recipeID ?? 0)
                    ->orderBy('id', 'ASC');
            })
            ->headAction(
                $this->addHeadAction()->when($this->readOnly === false)
            )
            ->rowActions(fn(RecipeStep $RecipeStep) => [
                (new OpenModalRowAction(
                    'Editar',
                    route('admin.receitas.addStep', [
                        'recipeCodedId' => $this->Recipe?->codedId,
                        'recipeStepCodedId' => $RecipeStep?->codedId,
                        'json' => true
                    ]),
                    '<i class="fa-solid fas fa-pencil-alt fa-fw"></i>'
                ))->when($this->readOnly === false),
                (new DestroyRowAction())->when($this->readOnly === false),
            ]);
    }

    protected function columns(): array
    {
        return [
            Column::make('title')->title('Título'),
            Column::make('description')->title('Descrição'),
        ];
    }

    private function init(): void
    {
        $this->Recipe = Recipe::where('id', '=', $this->recipeID)->first();
    }

    private function addHeadAction(): OpenModalHeadAction
    {
        return new OpenModalHeadAction(
            route('admin.receitas.addStep',
            ['recipeCodedId' => $this->Recipe->codedId, 'json' => true]),
            'Adicionar',
            '<i class="fas fa-plus"></i>',
            [],
            ['btn', 'btn-primary', 'btn-sm']
        );
    }
}
