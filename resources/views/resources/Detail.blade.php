@extends('Zoroaster::layout')

@section('content')

    <script>
        var Zoroaster_resource_index ='{{ route('Zoroaster.resource.index',['resource'=> $request->resourceClass ]) }}';
        var Zoroaster_resource_name ='{{ $request->resourceClass }}';
    </script>
    <div class="uk-card ">

        <div class="BuilderFields">


            <div class="uk-child-width-1-2 resourceName_2 view_Details" uk-grid>
                <div>
                    <h1 class="resourceName">مشاهدی {{ $resourceClass->singularLabel }}</h1>
                </div>
                <div class="uk-text-left ResourceActions">
                    {!! Zoroaster::ResourceActions($request->Resource(),$resources,$model,'Detail',null) !!}
                </div>
            </div>

            {!! $fields !!}

        </div>
    </div>

@stop