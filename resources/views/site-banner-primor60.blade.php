@php
/*
View variables:
===============
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Primor 60%'
])

@section('BODY_CONTENT')

    <section id="banner-primor-60" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 pt-1">
                        <h2 class="mb-4">
                            <span class="title stash">Lançamento</span><br />
                            <span class="title black clear">Primor 60%</span>
                        </h2>
                    </div>
                    <div class="col-12 col-lg-6 text-clear pt-4">
                        <p>
                            Para contemplar novos usos, nosso portfólio de produtos cresceu. Agora contamos com a <strong>Primor 60%</strong> no balde 
                            de <strong>3kg</strong>, uma <strong>novidade primorosa</strong> para os empreendedores 
                            da gastronomia, que precisam ter <strong>sempre a melhor margarina</strong> na hora de levar suas receitas para o forno ou fogão.
                        </p>
                    </div>
                </div>

                <div class="row mt-4 pt-4">
                    <div class="col">
                        <img class="responsive border-rounded" alt="Primor - Top of Mind" src="{{ url('/') }}/templates/primor-v1/images/page-primor-60-topo.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="banner-primor-60-bot" class="pt-4 pb-4">
        <div class="content-wrapper pt-2 pt-sm-5">
            <div class="container pt-2 pt-sm-5">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <h2>
                            <span class="title stash">É a Primor ...</span>
                        </h2>
                        <p class="color-wine">
                            Com um ouvido atento às necessidades de quem <strong>mais entende do seu sabor.</strong>
                            Nessa nova proposta, a experiência culinária será aprimorada, principalmente para bolos, empadas, tortas e receitas do tipo.
                            <strong>Prove</strong> e nos diga o que achou! <strong>Primor é o sabor que conta</strong> para o seu negócio.
                        </p>
                    </div>

                    <div class="col-12 col-lg-7 text-lg-left text-center">
                        <img id="bp6b-image-old" class="responsive" src="{{ url('/') }}/templates/primor-v1/images/page-primor-60-bot-image.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection