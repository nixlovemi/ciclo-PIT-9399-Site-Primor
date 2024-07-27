@php
/*
View variables:
===============
    - $_data: array
*/
@endphp

<ul>
    <li><strong>Nome</strong>: {{ $_data['f-nome'] ?? '' }}</li>
    <li><strong>E-mail</strong>: {{ $_data['f-email'] ?? '' }}</li>
    <li><strong>Telefone</strong>: {{ $_data['f-telefone'] ?? '' }}</li>
    <li><strong>Celular</strong>: {{ $_data['f-celular'] ?? '' }}</li>
    <li><strong>Data de Nascimento</strong>: {{ $_data['f-nascimento'] ?? '' }}</li>
    <li><strong>Gênero</strong>: {{ $_data['f-genero'] ?? '' }}</li>
    <li><strong>Assunto</strong>: {{ $_data['f-assunto'] ?? '' }}</li>
    <li><strong>Autorizo o uso das minhas informações para receber e-mails com novidades e lançamentos da Primor</strong>: {{ (isset($_data['f-check-newsletter']) && $_data['f-check-newsletter'] == 1) ? 'Sim': 'Não' }}</li>
    <li><strong>Confirmo que li e aceito a Política de Privacidade</strong>: {{ (isset($_data['f-check-privacy']) && $_data['f-check-privacy'] == 1) ? 'Sim': 'Não' }}</li>
    <li><strong>Mensagem</strong>:<br />
        @php
        echo nl2br($_data['f-mensagem'] ?? '');
        @endphp
    </li>
</ul>