@php
/*
View variables:
===============
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Círio de Nazaré'
])

@section('BODY_CONTENT')

    <section id="banner-cirio-nazare" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 pt-1">
                        <h2 class="mb-4">
                            <span class="title black clear">A</span> <span class="title stash">alegria</span> <span class="title black clear">de ser</span><br />
                            <span class="title black clear">o sabor que conta</span><br />
                            <span class="title black clear">no Círio de Nazaré</span>
                        </h2>
                    </div>
                    <div class="col-12 col-md-6 text-clear">
                        <p>Em Belém do Pará, cultura e culinária sentam
                        à mesa e fazem uma festança!</p>

                        <p>O Círio de Nazaré, é um evento tradicional que reúne milhares de pessoas numa celebração de fé, sabores e tradições.</p>

                        <p>E onde tem gastronomia, tem Primor fazendo essas receitas darem certo.</p>
                    </div>
                </div>

                <div class="row mt-4 pt-4">
                    <div class="col">
                        <img class="responsive border-rounded" alt="Primor - Top of Mind" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-topo.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="banner-cirio-nazare-bot" class="pt-4 pb-4">
        <div class="content-wrapper pt-2 pt-sm-5">
            <div class="container pt-2 pt-sm-5">
                <div class="row">
                    <div class="col-10 offset-1">
                        <div id="bcn-row-photos" class="row">
                            <div class="col">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal-img-1">
                                    <img class="responsive border-rounded" alt="Círio de Nazaré 01" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-img-01.jpg" />
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal-img-2">
                                    <img class="responsive border-rounded" alt="Círio de Nazaré 02" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-img-02.jpg" />
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal-img-3">
                                    <img class="responsive border-rounded" alt="Círio de Nazaré 03" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-img-03.jpg" />
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
                    <img class="responsive border-rounded" alt="Círio de Nazaré 01" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-img-01.jpg" />
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
                    <img class="responsive border-rounded" alt="Círio de Nazaré 01" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-img-02.jpg" />
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
                    <img class="responsive border-rounded" alt="Círio de Nazaré 01" src="{{ url('/') }}/templates/primor-v1/images/page-cirio-nazare-img-03.jpg" />
                </div>
            </div>
        </div>
    </div>

@endsection