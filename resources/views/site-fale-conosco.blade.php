@php
/*
View variables:
===============
    - $ARR_GENERO: array
    - $ARR_ASSUNTO: array
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Fale Conosco'
])

@section('BODY_CONTENT')

    <section id="contact" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <h2 class="mb-4">
                    <span class="title stash">Fale</span>
                    &nbsp;
                    <span class="title black clear">CONOSCO</span>
                </h2>

                <p class="text-clear">
                    Há mais de 60 anos, Primor faz parte do dia a dia de muitas<br />
                    famílias brasileiras. Ouvir você nos faz sentir parte da família.
                </p>
            </div>
        </div>
    </section>

    <section id="contact-form" class="pt-4 pb-4">
        <div class="content-wrapper">
            <div class="container">
                <h2>
                    <span class="title stash">Envie</span><br />
                    <span class="title black color-red">UMA MENSAGEM</span>
                </h2>
                <h5 class="mb-5">
                    <strong>
                        Preencha o formulário<br />
                        e entraremos em contato.
                    </strong>
                </h5>

                @include('partials.alertReturnMessages')

                <div class="row">
                    <div class="col-12 col-md-6">
                        <form method="POST" action="/do-fale-conosco">
                            @csrf

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="f-nome">Nome *</label>
                                        <input type="text" value="{{ old('f-nome') }}" class="form-control" id="f-nome" name="f-nome" placeholder="Digite seu Nome" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="f-email">E-mail *</label>
                                        <input type="email" value="{{ old('f-email') }}" class="form-control" id="f-email" name="f-email" placeholder="Digite seu e-mail" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="f-telefone">Telefone *</label>
                                        <input type="text" value="{{ old('f-telefone') }}" class="form-control" id="f-telefone" name="f-telefone" placeholder="DDD + Telefone" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="f-celular">Celular *</label>
                                        <input type="text" value="{{ old('f-celular') }}" class="form-control" id="f-celular" name="f-celular" placeholder="DDD + Celular" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="f-nascimento">Data de Nascimento *</label>
                                        <input type="text" value="{{ old('f-nascimento') }}" class="form-control" id="f-nascimento" name="f-nascimento" placeholder="dd/mm/aaaa" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="f-genero">Gênero</label>
                                        <select id="f-genero" name="f-genero" class="form-control">
                                            <option value="">Escolha</option>
                                            @foreach ($ARR_GENERO ?? [] as $genero)
                                                <option {{ old('f-genero') == $genero ? 'selected' : '' }} value="{{ $genero }}">{{ $genero }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="f-assunto">Assunto</label>
                                        <select name="f-assunto" id="f-assunto" class="form-control">
                                            <option value="">Selecione</option>
                                            @foreach ($ARR_ASSUNTO ?? [] as $assunto)
                                                <option {{ old('f-assunto') == $assunto ? 'selected' : '' }} value="{{ $assunto }}">{{ $assunto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="f-mensagem">Mensagem</label>
                                        <textarea class="form-control" name="f-mensagem" id="f-mensagem" rows="3">{{ old('f-mensagem') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input value="1" {{ old('f-check-newsletter') == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="f-check-newsletter" name="f-check-newsletter" />
                                            <label class="form-check-label" for="f-check-newsletter">
                                                Autorizo o uso das minhas informações para receber e-mails com novidades e lançamentos da Primor.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input value="1" {{ old('f-check-privacy') == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="f-check-privacy" name="f-check-privacy" />
                                            <label class="form-check-label" for="f-check-privacy">
                                                Confirmo que li e aceito a Política de Privacidade.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center text-md-right">
                                    <input type="submit" value="ENVIAR" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 mt-5 col-md-6 mt-md-0">
                        <div id="canais-atendimento">
                            <h3 class="mb-5"><strong>Nossos canais de atendimento</strong></h3>

                            <p>
                                <i class="fas fa-phone-alt fa-border"></i>
                                <br />
                                <strong>Telefone</strong>
                                <br />
                                0800 021 5260
                                <br />
                                Segunda à Sexta - 8h às 20h
                            </p>

                            <p>
                                <i class="fab fa-whatsapp fa-border"></i>
                                <br />
                                <strong>WhatsApp</strong>
                                <br />
                                (11) 91035-4902
                                <br />
                                Segunda à Sexta - 8h às 20h
                            </p>

                            <p>
                                <i class="fas fa-envelope fa-border"></i>
                                <br />
                                <strong>Email</strong>
                                <br />
                                sac@seara.com.br
                                <br />
                                Segunda à Sexta - 8h às 20h
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection