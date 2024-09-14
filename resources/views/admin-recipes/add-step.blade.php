@php
/*
View variables:
===============
    - $RECIPE: App\Models\Recipe
    - $RECIPE_STEP: App\Models\RecipeStep|null
*/

$RECIPE_STEP = $RECIPE_STEP ?? null;
@endphp

@extends('layout.modal', [
    'divId' => date('YmdHis') . rand(),
    'maxHeight' => '100vh',
    'maxWidth' => '800px'
])

@section('MODAL_HEADER')
    <h5 class="modal-title">
        @if(null !== $RECIPE_STEP)
            Editar Modo de Preparo
        @else
            Adicionar Modo de Preparo
        @endif
    </h5>
@endsection

@section('MODAL_BODY')
    <form id="recipeStep-add" method="POST" action="{{ route('admin.receitas.doSaveStep') }}">
        <input type="hidden" name="rcid" value="{{ $RECIPE?->codedId }}" />
        <input type="hidden" name="scid" value="{{ $RECIPE_STEP?->codedId }}" />
        @csrf

        <div class="row mb-4">
            <div class="col-12">
                <div class="form-group">
                    <label>Título</label>
                    <input maxlength="60" value="{{ $RECIPE_STEP?->title }}" name="f-title" type="text" class="form-control input-default" placeholder="Título" />
                    <small>Se preenchido, vai criar um título antes da descrição</small>
                </div>
            </div>
            
            <div class="col-12">
                <label>Descrição *</label>
                <textarea
                    class="form-control h-150px"
                    rows="4"
                    name="f-description"
                    placeholder="Descrição"
                >{{ $RECIPE_STEP?->description }}</textarea>
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