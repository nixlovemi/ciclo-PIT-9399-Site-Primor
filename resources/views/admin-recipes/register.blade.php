@inject('hlpConstants', 'App\Helpers\Constants')

@php
/*
View variables:
===============
    - $TITLE: string
    - $TYPE: string (hlpConstants::FORM_ACTIONS)
    - $ACTION: string
    - $RECIPE: App\Models\Recipe
*/

$TITLE = $TITLE ?? 'Receita';
if (false === array_search($TYPE ?? '', $hlpConstants::FORM_ACTIONS)) {
    $TYPE = $hlpConstants::FORM_VIEW;
}
$ACTION = $ACTION ?? '';
$RECIPE = $RECIPE ?? null;
@endphp

@extends('layout.admin-dash-core', [
    'PAGE_TITLE' => $TITLE ?? ''
])

@section('HEADER_CUSTOM_CSS')
@endsection

@section('DASH_BODY_CONTENT')
    <h2>
        @if ($TYPE === 'view')
            Visualizar Receita ID{{ $RECIPE?->id }}
        @elseif ($TYPE === 'edit')
            Editar Receita ID{{ $RECIPE?->id }}
        @elseif ($TYPE === 'add')
            Adicionar Receita
        @endif
    </h2>

    @include('partials.alertReturnMessages')

    <form method="POST" action="{{ $ACTION }}" enctype="multipart/form-data">
        <input type="hidden" name="f-cid" value="{{ $RECIPE?->codedId }}" />
        @csrf

        @php
        $accordionOne = view('admin-recipes.partials.info', [
            'RECIPE' => $RECIPE,
            'READONLY' => $TYPE === $hlpConstants::FORM_VIEW
        ])->render();
        @endphp
        <x-accordeon 
            id="accordion-one"
            title="Informações Gerais"
            :content="$accordionOne"
        />

        @if ($TYPE !== $hlpConstants::FORM_ADD)
            @php
            $accordionTwo = view('admin-recipes.partials.ingredients', [
                'RECIPE' => $RECIPE,
                'READONLY' => $TYPE === $hlpConstants::FORM_VIEW
            ])->render();
            @endphp
            <x-accordeon 
                id="accordion-two"
                title="Ingredientes"
                :content="$accordionTwo"
            />

            @php
            $accordionThree = view('admin-recipes.partials.steps', [
                'RECIPE' => $RECIPE,
                'READONLY' => $TYPE === $hlpConstants::FORM_VIEW
            ])->render();
            @endphp
            <x-accordeon 
                id="accordion-three"
                title="Modo de Preparo"
                :content="$accordionThree"
            />
        @endif

        <div class="form-actions pb-4">
            <div class="text-right">
                @if ($hlpConstants::FORM_VIEW !== $TYPE)
                    <button type="submit" class="btn btn-primary">
                        @if ($TYPE === $hlpConstants::FORM_ADD)
                            Próxima Etapa
                        @else
                            Salvar
                        @endif
                    </button>
                @endif
                
                <a href="{{ route('admin.receitas.index') }}" class="btn btn-outline-dark">Voltar para lista</a>
            </div>
        </div>
    </form>
@endsection

@section('FOOTER_CUSTOM_JS')
@endsection