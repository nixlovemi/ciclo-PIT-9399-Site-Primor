@php
/*
View variables:
===============
    - $PAGE_TITLE: string
*/
@endphp

@extends('layout.admin-core', [
    'PAGE_TITLE' => $PAGE_TITLE ?? ''
])

@section('BODY_CONTENT')
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="{{ route('admin.dashboard') }}">
                    <img class="responsive" src="{{ url('/') }}/templates/admin-v1/images/header-logo-admin-primor.png" alt="" />
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <img src="data:image/png;base64, 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" height="40" width="40" alt="" />
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.login') }}">
                                                <i class="icon-key"></i>
                                                <span>Sair</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                @include('partials.adminMenu')
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            @php
            /*
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            */
            @endphp

            <div class="container-fluid">
                @yield('DASH_BODY_CONTENT')
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
@endsection