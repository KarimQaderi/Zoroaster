@extends('Zoroaster::layout')

@section('content')

    <div class="uk-card ">

        <form class="BuilderFields"
              @isset($resources)
              action="{{ route('Zoroaster.resource.update',['resoure'=> $request->resourceClass,'resourceId'=> $resources->{$model->getKeyName()}]) }}"
              @else
              action="{{ route('Zoroaster.resource.store',['resoure'=> $request->resourceClass ]) }}"
              @endisset
              method="POST">

            <h1 class="resourceName">
                @isset($resources)
                    ویرایش
                @else
                    اضافه کردن
                @endisset
                {{ $resourceClass->label }}</h1>

            @csrf

            @isset($resources)
                @method('PUT')
            @endisset


            {!! $fields !!}

        </form>
    </div>
@stop