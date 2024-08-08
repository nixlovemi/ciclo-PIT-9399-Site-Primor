@php
/*
View variables:
===============
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Sabor que Conta'
])

@section('BODY_CONTENT')

    <section id="banner-sabor-que-conta" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h2 class="mb-4">
                            <span class="title black clear">Conheça</span><br />
                            <span class="title black clear">o</span> <span class="title stash">sabor</span><br />
                            <span class="title black clear">que conta</span>
                        </h2>
                    </div>
                    <div class="col-12 col-md-6 text-clear mt-5">
                        <p>A receita da nossa culinária é uma questão de sabor e Primor.</p>

                        <p>Nas mesas do Norte e Nordeste, é a Primor que dá um toque especial para os pratos que passam de geração em geração e representam culturas tradicionais.
                        O sabor que conta e que chama todo mundo pra perto.</p>
                    </div>
                </div>

                <div class="row mt-4 pt-4">
                    <div class="col">
                        <img class="responsive border-rounded" alt="Primor - Sabor que Conta" src="{{ url('/') }}/templates/primor-v1/images/page-sabor-que-conta-topo.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection