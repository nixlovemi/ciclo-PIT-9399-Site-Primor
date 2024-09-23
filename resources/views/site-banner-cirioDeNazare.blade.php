@php
/*
View variables:
===============
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Círio de Nazaré'
])

@section('BODY_CONTENT')

    <section id="banner-cirio-nazare" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 pt-1">
                        <h2 class="mb-4">
                            <span class="title black clear">A</span> <span class="title stash">alegria</span> <span class="title black clear">de ser</span><br />
                            <span class="title black clear">o sabor que conta</span><br />
                            <span class="title black clear">no Círio de Nazaré</span>
                        </h2>
                    </div>
                    <div class="col-12 col-md-6 text-clear">
                        <p>A receita do Círio tá pronta: fé, tradição e Primor.</p>
                        <p>
                            Em 2024, seremos patrocinadores oficiais do Círio de Nazaré, em Belém-PA.
                            Essa é uma celebração que movimenta não só o estado, mas também, o Brasil todo.
                        </p>
                        <p>
                            A cidade fica repleta de visitantes, todos movidos por uma tradição que tem tudo a ver com a Primor.
                            É pensando nisso que nossos trabalhos começaram desde já: Preparamos uma embalagem especial para o Círio, bonita de dar gosto.
                            Mas não para por aí, em breve tem muito mais do sabor que conta para você.
                            <strong>
                                Para acompanhar tudo é fácil demais, basta nos seguir na sua rede social favorita.
                                Estamos no Instagram, Facebook, Youtube e Tik Tok.
                            </strong>
                        </p>
                    </div>
                </div>

                <div class="row mt-4 pt-4">
                    <div class="col">
                        <img class="responsive border-rounded" alt="Primor - Top of Mind" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-topo.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection