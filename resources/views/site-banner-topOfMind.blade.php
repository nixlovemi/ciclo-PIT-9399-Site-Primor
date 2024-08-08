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

    <section id="banner-top-of-mind" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h2 class="mb-4">
                            <span class="title stash">Pela 13&ordf;</span><br />
                            <span class="title black clear">vez o</span><br />
                            <span class="title black clear">Nordeste</span><br />
                            <span class="title black clear">soube escolher</span><br />
                            <span class="title black clear">o sabor que não</span><br />
                            <span class="title black clear">sai das suas</span><br />
                            <span class="title black clear">receitas e das</span><br />
                            <span class="title black clear">suas melhores</span><br />
                            <span class="title black clear">memórias.</span>
                        </h2>

                        <img id="btom-icon-top" class="responsive" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-header-icon.png" />
                    </div>
                    <div class="col-12 col-md-6 pt-5">
                        <p><strong>O prêmio Top of Mind da Folha de São Paulo</strong> 
                        é resultado da maior pesquisa de lembrança 
                        de marcas da América Latina e uma das maiores 
                        do mundo. O estudo é realizado em todo o país, 
                        com a participação de marcas de diferentes 
                        segmentos no imaginário brasileiro.</p>

                        <p>Já são 33 edições e, no Nordeste, a Primor está 
                        no topo como marca mais lembrada por 13 vezes seguidas. Esse resultado nos ajuda a confirmar que trabalhar respeitando as tradições e culturas 
                        do Nordeste é o melhor caminho para conquistar 
                        o carinho de tantas famílias.</p>

                        <p>Essa conquista nos enche de orgulho e gratidão. 
                        Por isso, agradecemos a cada um dos nossos consumidores do Nordeste e também aos nossos colaboradores primorosos, que escrevem conosco 
                        essa história e fazem com que nosso sabor chegue 
                        na mesa de milhões de pessoas.</p>
                    </div>
                </div>

                <div class="row mt-4 pt-4">
                    <div class="col">
                        <img class="responsive border-rounded" alt="Primor - Top of Mind" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-topo.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection