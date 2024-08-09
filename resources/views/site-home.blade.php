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
                    'VIDEO_SRC' => url('/') . '/templates/primor-v1/images/primor_sabor_que_conta_30seg_WEB.mp4'
                ])

                <p class="text-center">
                    <a class="button-clear" href="{{ route('site.campanha') }}">VER TODOS OS VÍDEOS</a>
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

                @include('partials.products')
            </div>
        </div>
    </section>

@endsection