@php
/*
View variables:
===============
*/
@endphp

@extends('layout.modal', [
    'divId' => date('YmdHis') . rand(),
    'maxHeight' => '100vh',
    'maxWidth' => '800px'
])

@section('MODAL_HEADER')
    <h5 class="modal-title">
        Test
    </h5>
@endsection

@section('MODAL_BODY')
    BODY
@endsection