@extends('back.layouts.app')
@section('title','داشبورد')
@section('content')

    <div class="tm-content uk-padding-remove-vertical uk-section-muted uk-height-viewport">
        <div class="tm-container uk-container uk-container-expand uk-padding-small">
            {!! $Fields !!}

        </div>
    </div>
@stop