@php
/*
View variables:
===============
    - $PRODUCT: array
*/
$PRODUCT = (object) $PRODUCT;
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => ($PRODUCT->titleShort ?? '')
])

@section('BODY_CONTENT')

    <section id="product-single" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5">
                        @include('partials.titleSingle', [
                            'TITLE' => $PRODUCT->titleShort,
                            'TITLE_CLASS' => 'text-clear'
                        ])

                        <p class="mt-4 text-clear">{{ $PRODUCT->description ?? '' }}</p>

                        @if (is_array($PRODUCT->iconChoices) && !empty($PRODUCT->iconChoices))
                            <div class="text-center text-md-left">
                                <h5 class="mt-4 mb-4 text-clear">
                                    <strong>Certa para qualquer escolha:</strong>
                                </h5>

                                @foreach ($PRODUCT->iconChoices as $icon)
                                    <img class="ps-icon-choices responsive mr-3" src="{{ $icon ?? '' }}" />
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-12 mt-4 col-md-7 mt-md-0">
                        <img alt="{{ $PRODUCT->title }}" class="responsive" src="{{ $PRODUCT->image ?? '' }}" />
                    </div>
                </div>

                <div class="row mt-3 pt-3">
                    <div class="col-12 mb-4 col-lg-6 mb-lg-0">
                        <h4 class="mb-3">
                            <span class="title black color-yellow">
                                <strong>Ingredientes</strong>
                            </span>
                        </h4>

                        <p class="text-clear">{{ $PRODUCT->ingredients ?? '' }}</p>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h4 class="mb-3">
                            <span class="title black color-yellow">
                                <strong>Informações Nutricionais</strong>
                            </span>
                        </h4>

                        @php
                        $nutritionalInfo = $PRODUCT?->nutritionalInfo ?? [];
                        $nutritionalInfo = (object) $nutritionalInfo;
                        @endphp
                        <table id="ps-info-nutri-table" class="table text-clear">
                            <thead>
                                <tr>
                                    <th colspan="2">{{ $nutritionalInfo->title ?? '' }}</th>
                                    <th>%VD*</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nutritionalInfo->items ?? [] as $item)
                                    <tr>
                                        <td>{{ $item['description'] ?? '' }}</td>
                                        <td>{{ $item['value'] ?? '' }}</td>
                                        <td>{{ $item['percentage'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-1 mb-4 pb-4 pt-4">
        <div class="content-wrapper">
            <div class="container">
                <h2>
                    <span class="title stash">Receitas</span><br />
                    <span class="title black color-red">Relacionadas</span>
                </h2>
                <h5 class="mb-5 color-red">
                    <strong>
                        Receitas primorosas que combinam com {{ $PRODUCT->titleShort ?? '' }}
                    </strong>
                </h5>

                <x-carousel-recipe />
            </div>
        </div>
    </section>

@endsection