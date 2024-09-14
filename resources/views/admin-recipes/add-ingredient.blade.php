@php
/*
View variables:
===============
    - $RECIPE: App\Models\Recipe
    - $RECIPE_INGREDIENT: App\Models\RecipeIngredient|null
*/

$RECIPE_INGREDIENT = $RECIPE_INGREDIENT ?? null;
@endphp

@extends('layout.modal', [
    'divId' => date('YmdHis') . rand(),
    'maxHeight' => '100vh',
    'maxWidth' => '800px'
])

@section('MODAL_HEADER')
    <h5 class="modal-title">
        @if(null !== $RECIPE_INGREDIENT)
            Editar Ingrediente
        @else
            Adicionar Ingrediente
        @endif
    </h5>
@endsection

@section('MODAL_BODY')
    <form id="recipeIngredient-add" method="POST" action="{{ route('admin.receitas.doSaveIngredient') }}">
        <input type="hidden" name="rcid" value="{{ $RECIPE?->codedId }}" />
        <input type="hidden" name="icid" value="{{ $RECIPE_INGREDIENT?->codedId }}" />
        @csrf

        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Quantidade</label>
                    <input maxlength="15" value="{{ $RECIPE_INGREDIENT?->quantity }}" name="f-quantity" type="text" class="form-control input-default" placeholder="Quantidade" />
                </div>
            </div>
            <div class="col-12 col-md-9">
                <label>Ingrediente *</label>
                <input maxlength="80" value="{{ $RECIPE_INGREDIENT?->description }}" name="f-description" type="text" class="form-control input-default" placeholder="Ingrediente" />
            </div>
        </div>

        <div class="form-actions">
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="javascript:;" data-dismiss="modal" aria-label="Close" class="btn-modal-close btn btn-light">Fechar</a>
            </div>
        </div>
    </form>
@endsection