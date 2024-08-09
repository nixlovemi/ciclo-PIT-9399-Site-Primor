@extends('layout.site-core', [
    'PAGE_TITLE' => 'Campanha'
])

@section('BODY_CONTENT')

    <section id="campaign" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h2>
                            <span class="title black clear">Conheça</span><br />
                            <span class="title black clear">o</span> <span class="title stash">sabor</span><br />
                            <span class="title black clear">que conta</span><br />
                        </h2>
                    </div>
                    <div class="col-12 mt-4 col-md-6 mt-md-0">
                        <p class="text-clear">
                            A receita da nossa culinária é uma questão de sabor e Primor. 
                            <br /><br />
                            Nas mesas do Norte e Nordeste, é a Primor que dá um toque especial para os pratos que passam de geração em geração e representam culturas tradicionais.
                            <br />
                            O sabor que conta e que chama todo mundo pra perto.
                        </p>
                    </div>
                </div>

                <div class="row mt-1 mt-sm-4 pt-1 pt-sm-4">
                    <div class="col">
                        @include('layout.video-embed', [
                            'VIDEO_SRC' => url('/') . '/templates/primor-v1/images/Clipe-campanha.mp4',
                            'ROUNDED' => true
                        ])
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection