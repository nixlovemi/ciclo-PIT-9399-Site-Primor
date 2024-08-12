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
                        <p>Em Belém do Pará, cultura e culinária sentam
                        à mesa e fazem uma festança!</p>

                        <p>O Círio de Nazaré, é um evento tradicional que reúne milhares de pessoas numa celebração de fé, sabores e tradições.</p>

                        <p>E onde tem gastronomia, tem Primor fazendo essas receitas darem certo.</p>
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