@php
/*
View variables:
===============
    - $PAGE_TITLE: string
*/
@endphp

@extends('layout.admin-dash-core', [
    'PAGE_TITLE' => $PAGE_TITLE ?? ''
])

@section('HEADER_CUSTOM_CSS')
@endsection

@section('DASH_BODY_CONTENT')
    <h2>Receitas</h2>

    <a href="{{ route('admin.receitas.add') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i>
        Adicionar
    </a>

    <div class="row">
        <div class="col">
            <livewire:table
                :config="App\Tables\RecipesTable::class"
            />
        </div>
    </div>
@endsection

@section('FOOTER_CUSTOM_JS')
@endsection