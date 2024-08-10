@php
/*
View variables:
===============
    - $RECEITA: array
    - $SHARE: LaravelShare
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

                <div class="search-holder mb-5">
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
                                    <a href="javascript:;" data-toggle="modal" data-target="#modal-share">
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

    <div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Compartilhe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div style="font-size:3em;" class="col text-center">
                            <a target="_blank" href="{{ $SHARE->facebook() }}"><i class="fab fa-facebook-square"></i></a>
                            <a target="_blank" href="{{ $SHARE->twitter() }}"><i class="fab fa-twitter-square"></i></a>
                            <a target="_blank" href="{{ $SHARE->pinterest() }}"><i class="fab fa-pinterest-square"></i></a>
                            <a target="_blank" href="{{ $SHARE->whatsapp() }}"><i class="fab fa-whatsapp-square"></i></a>
                            <a target="_blank" href="{{ $SHARE->telegram() }}"><i class="fab fa-telegram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection