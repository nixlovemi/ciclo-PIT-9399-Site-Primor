@extends('layout.site-core', [
    'PAGE_TITLE' => 'Home'
])

@section('BODY_CONTENT')

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
                                    <a class="products-btn" href="{{ route('site.produtosSingle', ['slug' => 'margarina-original-sal-primor-pote-500g']) }}">Conheça</a>
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

@endsection