@extends('Zoroaster::layout')

@section('content')

    <div class="uk-card card">

        <div class="BuilderFields">



            <div class="uk-child-width-1-2 resourceName_2 view_Details" uk-grid>
                <div>
                    <h1 class="resourceName">مشاهدی {{ $resourceClass->label }}</h1>
                </div>
                <div class="uk-text-left ResourceActions">
                    {!! Zoroaster::ResourceActions($request,$resources,$model,'Detail',null) !!}
                </div>
            </div>

            {!! $fields !!}

        </div>
    </div>
@stop