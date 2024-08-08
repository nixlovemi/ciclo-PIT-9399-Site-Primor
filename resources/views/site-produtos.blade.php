@extends('layout.site-core', [
    'PAGE_TITLE' => 'Produtos'
])

@section('BODY_CONTENT')

    <section id="product" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <h2>
                    <span class="title stash">Nossos</span>
                    &nbsp;
                    <span class="title black clear">PRODUTOS</span>
                </h2>
            </div>
        </div>
    </section>

    <section id="product-details" class="pt-4 pb-4">
        <div class="content-wrapper pt-2 pt-sm-5">
            <div class="container pt-2 pt-sm-5">
                @include('partials.products')
            </div>
        </div>
    </section>

@endsection