<?php

namespace App\Tables;

use App\Models\Recipe;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\RowActions\ShowRowAction;
use Okipa\LaravelTable\Table;
use App\Tables\RowActions\ActivateRowAction;
use App\Tables\RowActions\DeactivateRowAction;
use Okipa\LaravelTable\Filters\ValueFilter;
use Okipa\LaravelTable\Formatters\BooleanFormatter;

class RecipesTable extends AbstractTableConfiguration
{
    protected function table(): Table
    {
        return Table::make()->model(Recipe::class)
            ->rowActions(fn(Recipe $Recipe) => [
                (new ActivateRowAction('active'))
                    ->when(!$Recipe->active)
                    ->confirmationQuestion('Deseja marcar como ativa a receita `' . $Recipe->title . '`?')
                    ->feedbackMessage(false),
                (new DeactivateRowAction('active'))
                    ->when($Recipe->active)
                    ->confirmationQuestion('Deseja marcar como inativa a receita `' . $Recipe->title . '`?')
                    ->feedbackMessage(false),
                (new ShowRowAction(route('admin.receitas.view', ['codedId' => $Recipe->codedId])))
                    ->when(true),
            ])
            ->filters([
                new ValueFilter(
                    'Ativo (Todos):',
                    'active',
                    [
                        1 => 'Sim',
                        0 => 'Não',
                    ],
                    false
                ),
            ]);
    }

    protected function columns(): array
    {
        return [
            Column::make('id')->title('ID')->sortable(),
            Column::make('title')->title('Nome')->sortable()->searchable(),
            Column::make('type')->title('Tipo')->sortable()->searchable(),
            Column::make('active')->title('Ativo')->format(new BooleanFormatter()),
        ];
    }
}
