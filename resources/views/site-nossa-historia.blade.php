@extends('layout.site-core', [
    'PAGE_TITLE' => 'Nossa História'
])

@section('BODY_CONTENT')

    <section id="our-history" class="sec-top">
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

@endsection