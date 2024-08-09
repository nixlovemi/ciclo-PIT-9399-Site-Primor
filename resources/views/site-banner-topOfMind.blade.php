@php
/*
View variables:
===============
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Top of Mind'
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

    <section id="banner-top-of-mind-bot" class="pt-4 pb-4">
        <div class="content-wrapper pt-2 pt-sm-5">
            <div class="container pt-2 pt-sm-5">
                <div class="row">
                    <div class="col-10 offset-1">
                        <div id="bcn-row-photos" class="row">
                            <div class="col">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal-img-1">
                                    <img class="responsive border-rounded" alt="Top of Mind 01" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-img-01.jpg" />
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal-img-2">
                                    <img class="responsive border-rounded" alt="Top of Mind 02" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-img-02.jpg" />
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal-img-3">
                                    <img class="responsive border-rounded" alt="Top of Mind 03" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-img-03.jpg" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-img-1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="responsive border-rounded" alt="Círio de Nazaré 01" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-img-01.jpg" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-img-2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="responsive border-rounded" alt="Círio de Nazaré 01" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-img-02.jpg" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-img-3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="responsive border-rounded" alt="Círio de Nazaré 01" src="{{ url('/') }}/templates/primor-v1/images/page-top-of-mind-img-03.jpg" />
                </div>
            </div>
        </div>
    </div>

@endsection