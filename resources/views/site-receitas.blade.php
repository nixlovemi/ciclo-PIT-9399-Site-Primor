@inject('SysUtils', 'App\Helpers\SysUtils')

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Receitas'
])

@section('BODY_CONTENT')

    <section id="recipes" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <h2>
                    <span class="title stash">Receitas</span> <span class="title black clear">Primorosas</span>
                </h2>
                <h5>Seu dia vai ficar mais gostoso com uma de nossas receitinhas.</h5>

                <div class="search-holder">
                    <div class="sh-image">
                        <img alt="Primor - Receitas" class="responsive" src="templates/primor-v1/images/recipes-search-image.jpg" />
                    </div>
                    <div class="sh-search">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" value="" class="form-control" id="f-search" name="f-search" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="recipes-list" class="mt-5">
        <div class="content-wrapper">
            <div class="container">
                @php
                $recipes = $SysUtils::getRecipes();
                @endphp

                <div class="recipes-holder">
                    @include('partials.pageRecipesList', [
                        'RECIPES' => $recipes
                    ])
                </div>

                <!-- TODO: implement the pagination -->
                <p class="text-center mt-4 d-none">
                    <a class="button-red" href="javascript:;">CARREGAR MAIS</a>
                </p>

                <div class="row mt-5 pt-5">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <div class="row">
                            <div class="col-6">
                                <img class="responsive" alt="Primor - Receitas para seu negócio" src="templates/primor-v1/images/recipes-youtube.png" />
                            </div>
                            <div class="col-6">
                                <h4>
                                    <span class="title stash">Receitas</span> <span class="title black color-red">para o seu negócio</span>
                                </h4>
                                <p class="color-red">
                                    Acesse nosso canal no Youtube e confira receitas perfeitas para você que é empreendedor!
                                </p>
                            </div>
                        </div>
                        <p class="text-center mt-4">
                            <a class="button-red" href="javascript:;">VER RECEITAS</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection