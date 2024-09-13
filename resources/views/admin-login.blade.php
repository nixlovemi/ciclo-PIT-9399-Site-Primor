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

@section('HEADER_CUSTOM_CSS')
@endsection

@section('BODY_CONTENT')
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <a class="text-center mb-4" href="{{ route('admin.login') }}">
                            <img alt="Logotipo Primor" src="{{ url('/') }}/templates/primor-v1/images/header-logo-primor.png" />
                        </a>

                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                @include('partials.alertReturnMessages')

                                <form class="mt-1 mb-1 login-input" action="{{ route('admin.doLogin') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email" name="f-email" value="{{ old('f-email') }}" class="form-control" placeholder="Email" />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="f-password" class="form-control" placeholder="Senha" />
                                    </div>

                                    <button type="submit" class="btn login-form__btn submit w-100">Entrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('FOOTER_CUSTOM_JS')
@endsection