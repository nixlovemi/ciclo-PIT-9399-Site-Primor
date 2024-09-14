@php
/*
View variables:
===============
    - $PAGE_TITLE: string
*/
$V_TITLE = ($PAGE_TITLE ?? '') . ' | ' . env('SITE_DISPLAY_NAME');
@endphp

<!DOCTYPE html>
<html class="h-100" lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>{{ $V_TITLE }}</title>
        <!-- Favicon icon -->
        <link rel="shortcut icon" href="{{ url('/') }}/templates/primor-v1/images/favicon.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{ url('/') }}/templates/primor-v1/images/favicon.png" />
        <link rel="preload" as="font" href="{{ url('/') }}/templates/primor-v1/fonts/StashBold/Stash-Bold.woff2">
        @livewireStyles
        @yield('HEADER_CUSTOM_CSS')
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
        <link href="{{ url('/') }}/templates/admin-v1/css/style.css" rel="stylesheet" />
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/components/font-awesome-5/css/all.min.css' type='text/css' media='all' />
        <link rel='stylesheet' href='{{ url('/') }}/templates/components/sweetalert2-11.14.0/sweetalert2.min.css' type='text/css' media='all' />
        <link rel='stylesheet' href='{{ url('/') }}/templates/primor-v1/custom.css' type='text/css' media='all' />
        <style>
            /* =========== OKIPA TABLE =========== */
            .table > :not(caption) > * > * {
                padding: 8px 8px;
            }
            div.table-responsive,
            div.table-responsive input,
            div.table-responsive i,
            div.table-responsive ul.pagination .page-link,
            div.table-responsive select {
                font-size: 0.9em !important;
            }
            div.table-responsive .pe-xl-3 {
                padding-right: 0 !important;
            }
            div.table-responsive tfoot div.p-2 {
                padding: 0 !important;
            }
            .form-control-sm {
                min-height: calc(1.35em + .5rem + calc(var(--bs-border-width) * 2)) !important;
            }
            div.table-responsive .form-select {
                word-wrap: normal;
                display: block;
                width: 100%;
                padding: 4px 36px;
                -moz-padding-start: calc(0.75rem - 3px);
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                background-color: #fff;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right .75rem center;
                background-size: 16px 12px;
                border: 1px solid #ced4da;
                border-radius: .25rem;
                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }
            div.table-responsive .input-group * {
                height: 60% !important;
                min-height: auto !important;
            }
            div.table-responsive #search-for-rows {
                height: 34px !important;
            }
            div.table-responsive .btn-link {
                height: 20px !important;
                padding: 0 0.5rem !important;
            }
            div.table-responsive .pagination {
                margin-bottom: 0;
            }
            div.table-responsive tbody tr:nth-child(even) {
                background: #fcfcfc;
            }
            div.table-responsive tbody tr:nth-child(odd) {
                background: #f1f1f1;
            }
            /* =================================== */
        </style>
    </head>
    <body class="h-100">
        <!--*******************
            Preloader start
        ********************-->
        <div id="preloader">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
        <!--*******************
            Preloader end
        ********************-->

        @yield('BODY_CONTENT')

        <!--**********************************
            Scripts
        ***********************************-->
        <script src="{{ url('/') }}/templates/admin-v1/plugins/common/common.min.js"></script>
        <script src="{{ url('/') }}/templates/admin-v1/js/custom.min.js"></script>
        <script src="{{ url('/') }}/templates/admin-v1/js/settings.js"></script>
        <script src="{{ url('/') }}/templates/admin-v1/js/gleek.js"></script>
        <script src="{{ url('/') }}/templates/admin-v1/js/styleSwitcher.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/components/font-awesome-5/js/all.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/templates/components/jquery-loading-overlay-2.1.7/dist/loadingoverlay.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/templates/components/sweetalert2-11.14.0/sweetalert2.all.min.js"></script>
        @livewireScripts
        @yield('FOOTER_CUSTOM_JS')
        <script type="text/javascript" src="{{ url('/') }}/templates/primor-v1/custom.js"></script>
    </body>
</html>