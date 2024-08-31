@php
/*
View variables:
===============
    - $MARG_TRAD_URL: string
    - $MARG_TABLETE_URL: string
    - $MARG_BALDE_URL: string
    - $GORD_VEGETAL_URL: string
*/
$MARG_TRAD_URL = $MARG_TRAD_URL ?? 'javascript:;';
$MARG_TABLETE_URL = $MARG_TABLETE_URL ?? 'javascript';
$MARG_BALDE_URL = $MARG_BALDE_URL ?? 'javascript';
$GORD_VEGETAL_URL = $GORD_VEGETAL_URL ?? 'javascript';
@endphp

<div class="partials-products">
    <div class="row ml-0 mr-0">
        <div class="col1">
            <div class="products">
                <div class="row">
                    <div class="col">
                        <div class="title">Margarina<br />Tradicional</div>
                        <a class="products-btn" href="{{ $MARG_TRAD_URL }}">Conheça</a>
                    </div>
                    <div class="col">
                        <div class="img" id="margarina-tradicional">
                            <img alt="Primor - Margarina Tradicional" class="responsive" src="{{ url('/') }}/templates/primor-v1/images/product-01.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col2">
            <div class="products no-image text-center">
                <div class="row">
                    <div class="col">
                        <div class="title">Margarina<br />Tablete</div>
                        <a class="products-btn" href="{{ $MARG_TABLETE_URL }}">Conheça</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-0 mt-sm-5 ml-0 mr-0">
        <div class="col1">
            <div class="products">
                <div class="row">
                    <div class="col">
                        <div class="title">Margarina<br />Balde</div>
                        <a class="products-btn" href="{{ $MARG_BALDE_URL }}">Conheça</a>
                    </div>
                    <div class="col">
                        <div class="img" id="margarina-balde">
                            <img alt="Primor - Margarina Balde" class="responsive" src="{{ url('/') }}/templates/primor-v1/images/product-03-margarina-balde-3kg.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col2">
            <div class="products">
                <div class="row">
                    <div class="col">
                        <div class="title">Gordura<br />Vegetal</div>
                        <a class="products-btn" href="{{ $GORD_VEGETAL_URL }}">Conheça</a>
                    </div>
                    <div class="col">
                        <div class="img" id="gordura-vegetal">
                            <img alt="Primor - Gordura Vegetal" class="responsive" src="{{ url('/') }}/templates/primor-v1/images/product-04-gordura-vegetal.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>