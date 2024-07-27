@extends('layout.site-core', [
    'PAGE_TITLE' => 'Nossa História'
])

@section('BODY_CONTENT')

    <section id="our-history">
        <div class="content-wrapper">
            <div class="container">
                <h2>
                    <span class="title black clear">PRIMOR É O SABOR</span><br />
                    <span class="title black clear">QUE</span>&nbsp;<span class="title stash">Conta Histórias</span><br />
                    <span class="title black clear">NO NORTE E NO NORDESTE</span><br />
                </h2>

                <div class="row mt-5 pb-5">
                    <div class="col text-center">
                        <img id="nossa-historia-img-top" alt="Primor - Nossa História" src="templates/primor-v1/images/nossa-historia-img-top.jpg" class="responsive" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="our-history-about" class="pt-4 pb-4">
        <div class="content-wrapper">
            <div class="container">
                <h2>
                    <span class="title stash">Sobre Nós</span><br /><br />
                </h2>
                <h5>
                    <span class="title black color-red">Nosso sabor<br />chama para perto</span>
                </h5>

                <div class="row">
                    <div class="col-6 col-md-5">
                        <p>Onde tem família reunida, <strong>tem muito amor e Primor envolvidos.</strong> São mais de 60 anos levando qualidade e sabor, do café da manhã ao jantar.</p>
                        <p>E quando as mesas e cozinhas se preparam para a festa, a Primor também está lá. <strong>Celebrando culturas, valorizando tradições,</strong> sendo o sabor que conta das receitas que, mais que ingredientes, carregam a identidade de um povo.</p>
                    </div>
                </div>
            </div>
        </div>

        <img id="nossa-historia-food-min" src="templates/primor-v1/images/nossa-historia-food-min.png" alt="Primor - Sobre Nós" class="responsive" />
    </section>

    <!--
    @include('partials.siteHeaderCarousel')

    <section class="mt-1 mb-4 pb-4 pt-4">
        <div class="content-wrapper">
            <div class="container">
                <h2>
                    <span class="title stash">Descubra o segredo</span><br />
                    <span class="title black">da nossa culinária</span>
                </h2>
                <p>Do Norte ao Nordeste, cozinhar bem é uma questão de Primor.</p>

                @include('layout.video-embed', [
                    'VIDEO_SRC' => 'https://www.youtube.com/embed/QhifyOknFjI?rel=0'
                ])

                <p class="text-center">
                    <a class="button-clear" href="javascript:;">VER TODOS OS VÍDEOS</a>
                </p>
            </div>
        </div>
    </section>

    <section id="receitas" class="pt-5">
        <div class="content-wrapper mt-3">
            <div class="container">
                <h2>
                    <span class="title stash">Receitas</span><br />
                    <span class="title black clear">Primorosas</span>
                </h2>
                <p class="text-clear mb-5">
                    Pra garantir os elogios, prepare tudo do<br />
                    seu jeitinho: com amor e com Primor.
                </p>
                
                <x-carousel-recipe />
            </div>
        </div>
    </section>

    <section id="produtos">
        <div class="content-wrapper mt-3 pt-5">
            <div class="container pt-2">
                <h2>
                    <span class="title stash">Linha</span><br />
                    <span class="title black">Margarina Primor</span>
                </h2>
                <p class="mb-5">
                    Conheça a nossa linha de produtos primorosos.
                </p>

                <div class="row ml-0 mr-0">
                    <div class="col1">
                        <div class="products">
                            <div class="row">
                                <div class="col">
                                    <div class="title">Margarina<br />Tradicional</div>
                                    <a class="products-btn" href="javascript:;">Conheça</a>
                                </div>
                                <div class="col">
                                    <div class="img" id="margarina-tradicional">
                                        <img alt="Primor - Margarina Tradicional" class="responsive" src="templates/primor-v1/images/product-01.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        <div class="products">
                            <div class="row">
                                <div class="col">
                                    <div class="title">Margarina<br />Tablete</div>
                                    <a class="products-btn" href="javascript:;">Conheça</a>
                                </div>
                                <div class="col">
                                    <div class="img" id="margarina-tablete">
                                        <img alt="Primor - Margarina Tablete" class="responsive" src="templates/primor-v1/images/product-02.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-0 mt-sm-5 ml-0 mr-0 text-center">
                    <div class="col1">
                        <div class="products no-image">
                            <div class="row">
                                <div class="col">
                                    <div class="title">Margarina<br />Balde</div>
                                    <a class="products-btn" href="javascript:;">Conheça</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        <div class="products no-image">
                            <div class="row">
                                <div class="col">
                                    <div class="title">Gordura<br />Vegetal</div>
                                    <a class="products-btn" href="javascript:;">Conheça</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    -->

@endsection