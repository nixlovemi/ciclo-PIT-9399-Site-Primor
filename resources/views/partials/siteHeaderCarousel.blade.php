@php
$items = [];

// Slide 01
$items[] = [
    'title' =>
        <<<HTML
            <span class="black">Mês do</span>
            <br />
            <span class="stash">Nordestino</span>
        HTML,
    'description' =>
        <<<HTML
            Desde sempre a Primor é ingrediente<br />
            nas receitas que contam a história do<br />
            Nordeste. Relembre o porquê.
        HTML,
    'descriptionShort' => null,
    'image' => 'templates/primor-v1/images/header-banner-01.jpg',
    'url' => route('site.banner.mesDoNordestino'),
];

// Slide 02
$items[] = [
    'title' =>
        <<<HTML
            <span class="stash">Top of Mind</span>
            <br />
            <span class="black">pela 13&ordf; vez</span>
        HTML,
    'description' =>
        <<<HTML
            No Nordeste todo mundo sabe qual a margarina<br />
            que melhor transforma sabores em histórias.
        HTML,
    'descriptionShort' => null,
    'image' => 'templates/primor-v1/images/header-banner-02.jpg',
    'url' => 'javascript:;',
];

// Slide 03
$items[] = [
    'title' =>
        <<<HTML
            <span class="black">Círio de</span>
            <br />
            <span class="stash">Nazaré</span>
        HTML,
    'description' =>
        <<<HTML
            Já virou tradição.<br />
            Todo ano tem Primor no Círio de Nazaré.
        HTML,
    'descriptionShort' => null,
    'image' => 'templates/primor-v1/images/header-banner-03.jpg',
    'url' => 'javascript:;',
];

// Slide 04
$items[] = [
    'title' =>
        <<<HTML
            <span class="stash">Lançamento</span>
            <br />
            <span class="black">Primor 60%</span>
        HTML,
    'description' =>
        <<<HTML
            Para continuar contando as histórias da sua<br />
            família e do seu negócio, a Primor cresceu.
        HTML,
    'descriptionShort' => null,
    'image' => 'templates/primor-v1/images/header-banner-04.jpg',
    'url' => 'javascript:;',
];

// Slide 05
$items[] = [
    'title' =>
        <<<HTML
            <span class="black">Conheça</span>
            <br />
            <span class="black">o</span>&nbsp;<span class="stash">sabor</span>
            <br />
            <span class="black">que conta.</span>
        HTML,
    'description' =>
        <<<HTML
            A Primor é o sabor que conta nas receitas<br />
            do Norte e do Nordeste. Ao seu lado fazemos<br />
            da cozinha um templo de cultura e tradição.<br />
            Descubra como mantemos essa chama acesa.
        HTML,
    'descriptionShort' => 
        <<<HTML
            A Primor é o sabor que conta nas receitas<br />
            do Norte e do Nordeste. Ao seu lado fazemos ...
        HTML,
    'image' => 'templates/primor-v1/images/header-banner-05.jpg',
    'link' => 'javascript:;',
];
@endphp

<x-carousel-single :slides="$items" />