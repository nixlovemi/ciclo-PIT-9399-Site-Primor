@inject('mNutritionalInfo', 'App\Interfaces\Product\NutritionalInfo')

@php
/*
View variables:
===============
    - $PRODUCT: App\Interfaces\Product\ProductAbstract;
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => ($PRODUCT?->getTitleShort() ?? '')
])

@section('BODY_CONTENT')

    <section id="product-single" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col text-right">
                        @php
                        $prodFamily = $PRODUCT?->getFamilyProdItems() ?? [];
                        @endphp

                        @if (is_array($prodFamily) && !empty($prodFamily))
                            <ul id="product-family">
                                @foreach ($prodFamily as $item)
                                    @php
                                    $item = new $item();
                                    $bSelected = $PRODUCT?->getFamilySize() == $item->getFamilySize();
                                    $strFamilySize = $item->getFamilySize() ?? '?';
                                    @endphp

                                    <li class="{{ $bSelected ? 'selected' : '' }}">
                                        @if (!$bSelected)
                                            <a href="{{ $item->getUrl() ?? 'javascript:;' }}">
                                                {{ $strFamilySize }}
                                            </a>
                                        @else
                                            {{ $strFamilySize }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-5">
                        @include('partials.titleSingle', [
                            'TITLE' => $PRODUCT?->getTitleShort(),
                            'TITLE_CLASS' => 'text-clear'
                        ])

                        <p class="mt-4 text-clear">{{ $PRODUCT?->getDescription() ?? '' }}</p>

                        @if (is_array($PRODUCT?->getIconChoices()) && !empty($PRODUCT?->getIconChoices()))
                            <div class="text-center text-md-left">
                                <h5 class="mt-4 mb-4 text-clear">
                                    <strong>Certa para qualquer escolha:</strong>
                                </h5>

                                @foreach ($PRODUCT?->getIconChoices() ?? [] as $icon)
                                    <img class="ps-icon-choices responsive mr-3" src="{{ $icon ?? '' }}" />
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-12 mt-4 col-md-7 mt-md-0 text-center">
                        @if (!empty($PRODUCT?->getImageUrl()))
                            <img alt="{{ $PRODUCT?->getTitle() }}" class="responsive" src="{{ $PRODUCT?->getImageUrl() ?? '' }}" />
                        @endif
                    </div>
                </div>

                <div class="row mt-3 pt-3">
                    <div class="col-12 mb-4 col-lg-6 mb-lg-0">
                        <h4 class="mb-3">
                            <span class="title black color-yellow">
                                <strong>Ingredientes</strong>
                            </span>
                        </h4>

                        <p class="text-clear">{!! $PRODUCT?->getIngredients() ?? '' !!}</p>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h4 class="mb-3">
                            <span class="title black color-yellow">
                                <strong>Informações Nutricionais</strong>
                            </span>
                        </h4>

                        @php
                        $nutritionalInfo = $PRODUCT?->getNutritionalInfo() ?? null;
                        $hide100g = $nutritionalInfo?->is100gHidden() ?? false;
                        @endphp
                        <table id="ps-info-nutri-table" class="table text-clear">
                            <thead>
                                <tr>
                                    <th>{!! $nutritionalInfo?->getTitle() ?? '' !!}</th>
                                    @if (!$hide100g)
                                        <th>100g</th>
                                    @endif
                                    <th>10g</th>
                                    <th>%VD*</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nutritionalInfo?->getItems() ?? [] as $item)
                                    <tr>
                                        <td>{!! $item[$mNutritionalInfo::ITEM_DESCRIPTION] ?? '' !!}</td>
                                        @if (!$hide100g)
                                            <td>{{ $item[$mNutritionalInfo::ITEM_VALUE_100G] ?? '' }}</td>
                                        @endif
                                        <td>{{ $item[$mNutritionalInfo::ITEM_VALUE_10G] ?? '' }}</td>
                                        <td>{{ $item[$mNutritionalInfo::ITEM_PERCENTAGE] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach ($nutritionalInfo?->getObs() ?? [] as $item)
                            {!! $item[$mNutritionalInfo::OBS_DESCRIPTION] ?? '' !!}
                        @endforeach
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
                        Receitas primorosas que combinam com {{ $PRODUCT?->getTitleShort() ?? '' }}
                    </strong>
                </h5>

                <x-carousel-recipe />
            </div>
        </div>
    </section>

@endsection