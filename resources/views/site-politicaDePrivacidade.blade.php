@php
/*
View variables:
===============
*/
@endphp

@extends('layout.site-core', [
    'PAGE_TITLE' => 'Política de Privacidade'
])

@section('BODY_CONTENT')

    <section id="politica-privacidade" class="sec-top">
        <div class="content-wrapper">
            <div class="container">
                <h2 class="mb-1">
                    <span class="title stash">Política</span> <span class="title black clear">de Privacidade</span>
                </h2>
            </div>
        </div>
    </section><li> - 

    <section id="politica-privacidade-content" class="pt-4 pb-4">
        <div class="content-wrapper">
            <div class="container">
                <h4>1. Introdução</h4>
                <p>
                    Bem-vindo ao site da Primor. Respeitamos sua privacidade e estamos comprometidos em proteger seus dados pessoais
                    de acordo com a Lei Geral de Proteção de Dados (LGPD) e outras legislações aplicáveis. Esta Política de Privacidade
                    descreve como coletamos, usamos, armazenamos e protegemos suas informações pessoais quando você visita nosso site.
                </p>
                
                <h4>2. Dados Pessoais Coletados</h4>
                <p>Coletamos dados pessoais que você nos fornece diretamente, tais como:</p>
                <ul>
                    <li> - Nome</li>
                    <li> - Endereço de e-mail</li>
                    <li> - Número de telefone</li>
                </ul>
                <p>Também podemos coletar dados automaticamente, como:</p>
                <ul>
                    <li> - Endereço IP</li>
                    <li> - Tipo de navegador</li>
                    <li> - Páginas visitadas</li>
                    <li> - Data e hora de acesso</li>
                </ul>
                
                <h4>3. Finalidades do Tratamento</h4>
                <p>Utilizamos seus dados pessoais para:</p>
                <ul>
                    <li> - Processar e gerenciar suas compras ou solicitações.</li>
                    <li> - Enviar comunicações relacionadas aos nossos produtos e serviços.</li>
                    <li> - Melhorar nosso site e personalizar sua experiência.</li>
                    <li> - Cumprir com obrigações legais e regulatórias.</li>
                </ul>
                
                <h4>4. Compartilhamento de Dados</h4>
                <p>Podemos compartilhar seus dados pessoais com terceiros apenas nas seguintes situações:</p>
                <ul>
                    <li> - Com prestadores de serviços que auxiliam na operação do nosso site e serviços, sempre sob acordos de confidencialidade.</li>
                    <li> - Em cumprimento a obrigações legais ou para proteger nossos direitos, propriedade ou segurança.</li>
                    <li> - Com parceiros comerciais, quando necessário, para a execução de contratos e ofertas de produtos ou serviços relevantes.</li>
                </ul>
                
                <h4>5. Armazenamento e Segurança</h4>
                <p>
                    Adotamos medidas de segurança apropriadas para proteger seus dados pessoais contra acesso não autorizado, alteração,
                    divulgação ou destruição. Seus dados são armazenados em servidores seguros e protegidos por tecnologia avançada.
                </p>
                
                <h4>6. Seus Direitos</h4>
                <p>De acordo com a LGPD, você tem os seguintes direitos em relação aos seus dados pessoais:</p>
                <ul>
                    <li> - Confirmar a existência de tratamento de dados.</li>
                    <li> - Acessar seus dados pessoais.</li>
                    <li> - Corrigir dados pessoais incompletos, inexatos ou desatualizados.</li>
                    <li> - Solicitar a anonimização, bloqueio ou eliminação de dados desnecessários.</li>
                    <li> - Revogar seu consentimento a qualquer momento, quando aplicável.</li>
                </ul>
                <p>Para exercer esses direitos, entre em contato conosco através dos canais abaixo.</p>
                
                <h4>7. Cookies e Tecnologias Semelhantes</h4>
                <p>
                    Utilizamos cookies e tecnologias semelhantes para melhorar sua experiência em nosso site, como lembrar suas preferências
                    e oferecer conteúdo personalizado. Você pode gerenciar suas preferências de cookies através das configurações do seu
                    navegador.
                </p>
                
                <h4>8. Alterações na Política de Privacidade</h4>
                <p>
                    Esta Política de Privacidade pode ser atualizada periodicamente para refletir mudanças em nossas práticas ou requisitos
                    legais. Recomendamos que você revise esta política regularmente para estar ciente de quaisquer alterações.
                </p>
                
                <h4>9. Contato</h4>
                <p>Se você tiver dúvidas ou preocupações sobre esta Política de Privacidade ou sobre o tratamento de seus dados pessoais, entre em contato conosco através dos seguintes canais:</p>
                <ul>
                    <li> - <strong>E-mail:</strong> <a href="mailto:{{ env('CONTACT_FORM_MAIL_TO') }}">{{ env('CONTACT_FORM_MAIL_TO') }}</a></li>
                </ul>
            </div>
        </div>
    </section>

@endsection