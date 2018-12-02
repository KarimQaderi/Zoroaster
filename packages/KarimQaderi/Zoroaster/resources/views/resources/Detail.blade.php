@extends('Zoroaster::layout')

@section('content')

    <div class="uk-card card">

        <div class="BuilderFields">

            <h1 class="resourceName">مشاهدی {{ $resourceClass->label }}</h1>



            {!! $fields !!}

        </div>
    </div>
@stop