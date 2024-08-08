@php
/*
View variables:
===============
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Mês do Nordestino'
])

@section('BODY_CONTENT')

    <section id="banner-mes-nordestino" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h2 class="mb-4">
                            <span class="title black clear">O Nordeste mora</span><br />
                            <span class="title stash color-wine">em nossos corações.</span><br />
                            <span class="title black clear">Não à toa,</span><br />
                            <span class="title black clear">estamos sempre</span><br />
                            <span class="title black clear">reunidos.</span>
                        </h2>

                        <h5>
                            <strong>
                                A marca mais lembrada<br />
                                de todos os Nordestes.
                            </strong>
                        </h5>
                    </div>
                    <div class="col-12 col-md-6 pt-5">
                        <p>Múltiplos Nordestes em um só.</p>
                        <p>Diversos sabores em cada um dos nove estados que fazem essa região tão plural em cultura, tradições e gostos. É muita, mas muita gente mesmo, criando ou perpetuando receitas.</p>
                        <p>E sabe o ponto que dá liga e une tantas pessoas ao redor das mesas? Primor, a margarina mais lembrada da região. Que sabor! Um orgulho desses a gente faz questão de dividir, igualzinho comida gostosa.</p>
                    </div>
                </div>
                
                <div class="row mt-4 pt-4">
                    <div class="col">
                        <img class="responsive border-rounded" alt="Primor - Mês do Nordestino" src="{{ url('/') }}/templates/primor-v1/images/page-mes-nordeste-topo.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection