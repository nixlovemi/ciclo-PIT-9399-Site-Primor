@php
/*
View variables:
===============
    - $PAGE_TITLE: string
    - $TOTAL_RECIPES: int
    - $ACTIVE_RECIPES: int
    - $INACTIVE_RECIPES: int
*/
@endphp

@extends('layout.admin-dash-core', [
    'PAGE_TITLE' => $PAGE_TITLE ?? ''
])

@section('HEADER_CUSTOM_CSS')
    <style>
        .adm-dash-recipe-info .card-widget__icon {
            font-size: 2.3em;
            color: #FFF;
        }
    </style>
@endsection

@section('DASH_BODY_CONTENT')
    <div class="row">
        <div class="col-4">
            <div class="card card-widget adm-dash-recipe-info">
                <div class="card-body gradient-6">
                    <div class="media">
                        <span class="card-widget__icon"><i class="fas fa-blender"></i></span>
                        <div class="media-body">
                            <h2 class="card-widget__title">{{ $TOTAL_RECIPES ?? 0 }}</h2>
                            <h5 class="card-widget__subtitle">Receitas cadastradas</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card card-widget adm-dash-recipe-info">
                <div class="card-body gradient-6">
                    <div class="media">
                        <span class="card-widget__icon"><i class="fas fa-thumbs-up"></i></span>
                        <div class="media-body">
                            <h2 class="card-widget__title">{{ $ACTIVE_RECIPES ?? 0 }}</h2>
                            <h5 class="card-widget__subtitle">Receitas Ativas</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card card-widget adm-dash-recipe-info">
                <div class="card-body gradient-6">
                    <div class="media">
                        <span class="card-widget__icon"><i class="fas fa-thumbs-down"></i></span>
                        <div class="media-body">
                            <h2 class="card-widget__title">{{ $INACTIVE_RECIPES ?? 0 }}</h2>
                            <h5 class="card-widget__subtitle">Receitas Inativas</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('FOOTER_CUSTOM_JS')
@endsection