@php
/*
View variables:
===============
    - $RECEITA: array
*/
$RECEITA = (object) $RECEITA;
@endphp

@inject('SysUtils', 'App\Helpers\SysUtils')

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Receita ' . ($RECEITA->title ?? '')
])

@section('BODY_CONTENT')

    <section id="recipes-single">
        <div class="content-wrapper">
            <div class="container">
                @include('partials.titleSingle', [
                    'TITLE' => $RECEITA->title
                ])

                <div class="search-holder mb-5 pb-5">
                    <div class="sh-image">
                        <img alt="Primor - Receitas" class="responsive" src="{{ $RECEITA->bannerSingle ?? '' }}" />
                    </div>
                    <div class="sh-search">
                        <div class="row pb-3">
                            <div class="col-6 mb-2 col-md-3 mb-md-0">
                                <span class="rs-info">
                                    <i class="far fa-clock"></i> {{ $RECEITA->timeStr ?? '' }}
                                </span>
                            </div>
                            <div class="col-6 mb-2 col-md-3 mb-md-0">
                                <span class="rs-info">
                                    <i class="fas fa-user-friends"></i> {{ $RECEITA->portionsStr ?? '' }}
                                </span>
                            </div>
                            <div class="col-6 mb-2 col-md-3 mb-md-0">
                                <span class="rs-info">
                                    <i class="fas fa-user-friends"></i> {{ $RECEITA->difficultyStr }}
                                </span>
                            </div>
                            <div class="col-6 mb-2 col-md-3 mb-md-0">
                                <span class="rs-info no-border">
                                    <a href="javascript:;">
                                        Compartilhar <i class="fas fa-share-alt"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="rs-ingredients" class="col-12 mb-4 col-md-6 mb-md-0">
                        <h4 class="mb-3">
                            <span class="title black">Ingredientes</span>
                        </h4>

                        @foreach ($RECEITA->ingredients ?? [] as $ingredient)
                            <p>
                                @if (isset($ingredient['qty']) && !empty($ingredient['qty']))
                                    <span class="color-red">{{ $ingredient['qty'] }}</span>
                                @endif

                                {{ $ingredient['item'] ?? '' }}
                            </p>
                        @endforeach
                    </div>
                    <div class="col-12 col-md-6">
                        <h4 class="mb-3">
                            <span class="title black">Modo de Preparo</span>
                        </h4>

                        @foreach ($RECEITA->steps ?? [] as $step)
                            <p>
                                @if (isset($step['title']) && !empty($step['title']))
                                    <strong>{{ $step['title'] }}</strong>
                                    <br />
                                @endif

                                {{ $step['desc'] ?? '' }}
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection