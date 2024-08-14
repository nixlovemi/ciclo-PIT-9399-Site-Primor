@php
/*
View variables:
===============
    - $PAGE_TITLE: string
*/
$V_TITLE = ($PAGE_TITLE ?? '') . ' | ' . env('SITE_DISPLAY_NAME');
@endphp

<!DOCTYPE html>
<html lang="pt-BR" itemscope itemtype="https://schema.org/WebPage">
    <head>
        <title>{{ $V_TITLE }}</title>

        <meta charset="UTF-8" />
        <meta name='robots' content='max-image-preview:large' />
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="shortcut icon" href="{{ url('/') }}/templates/primor-v1/images/favicon.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{ url('/') }}/templates/primor-v1/images/favicon.png" />

        <!-- Custom CSS -->
        <link rel="preload" as="font" href="{{ url('/') }}/templates/primor-v1/fonts/StashBold/Stash-Bold.woff2">
        @livewireStyles
        @yield('HEADER_CUSTOM_CSS')
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/reset.css' type='text/css' media='all' />
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/components/bootstrap/css/bootstrap.min.css' type='text/css' media='all' />
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/components/font-awesome-5/css/all.min.css' type='text/css' media='all' />
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/components/slick-carousel/slick.css' type='text/css' media='all' />
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/components/slick-carousel/slick-theme.css' type='text/css' media='all' />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- ========== -->
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/custom.css' type='text/css' media='all' />
    </head>

    <body>
        <style>
            .br-cookiebar.default {
                background: rgba(63, 12, 12, 0.85) !important;
            }
        </style>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v20.0" nonce="XB46yiPG"></script>

        <div id="header">
            <div class="content-wrapper">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-lg-3 col-4">
                            <h1 class="offset">{{ $V_TITLE }}</h1>
                            <a href="{{ route('site.home') }}">
                                <img id="header-logo-primor" alt="Logotipo Primor" src="{{ url('/') }}/templates/primor-v1/images/header-logo-primor.png" />
                            </a>
                        </div>
                        <div class="col-lg-9 col-8">
                            <div id="header-menu">
                                <x-menu-ul />
                            </div>

                            <div id="header-menu-mobile">
                                <a href="javascript:;">
                                    <i id="hmm-icon" class="fas fa-bars"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="header-mobile-menu">
                <div class="container">
                    <x-menu-ul />
                </div>
            </div>
        </div>
        
        @yield('BODY_CONTENT')

        <footer>
            <img id="footer-bg-wave" class="responsive" src="{{ url('/') }}/templates/primor-v1/images/footer-bg-wave.png" />
            <div class="container-fluid">
                <div class="container">
                    &nbsp; <!-- need to have this here O___O -->
                    <div id="footer-menu">
                        <x-menu-ul />
                    </div>
                    <p class="mt-3 mb-1">Segunda a sexta - 8h às 20h - Horário de Brasília</p>
                    <p class="mb-1">
                        <i class="fas fa-phone-alt mr-1"></i>
                        0800 021 5260 | (11) 91035-4902
                    </p>
                    <div class="row no-gutters">
                        <div class="col-12 col-md-5">
                            <p class="mb-0">
                                <i class="fas fa-envelope mr-1"></i>
                                sac@seara.com.br
                            </p>
                            <p id="footer-social-media">
                                <a target="_blank" href="https://www.tiktok.com/@primor.oficial"><i class="fab fa-tiktok"></i></a>
                                <a target="_blank" href="https://www.instagram.com/primor/"><i class="fab fa-instagram"></i></a>
                                <a target="_blank" href="https://www.facebook.com/PrimorAlimentos/"><i class="fab fa-facebook-square"></i></a>
                                <a target="_blank" href="https://www.youtube.com/@PrimorAlimentos"><i class="fab fa-youtube"></i></a>
                                <span>Acompanhe nas redes sociais</span>
                            </p>
                        </div>
                    </div>
                    <img class="responsive" id="footer-logo" src="{{ url('/') }}/templates/primor-v1/images/footer-logo.png" />
                </div>
            </div>
        </footer>

        <!-- ============================================================== -->
        <!-- All Required js -->
        <!-- ============================================================== -->
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/components/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/components/jquery/jquery-migrate.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/components/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/components/font-awesome-5/js/all.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/components/slick-carousel/slick.min.js"></script>
        @livewireScripts
        @yield('FOOTER_CUSTOM_JS')
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/custom.js"></script>
    </body>
</html>