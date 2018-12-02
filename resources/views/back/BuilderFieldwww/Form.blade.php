@extends('back.layouts.app')
@section('title','داشبورد')
@section('content')

    <div class="uk-card uk-padding tm-card-default">

        <form action="{{ isset($id)? route($route,$id) : route($route) }}" method="POST">
            @csrf
            @if ($method=='PUT')
                @method('PUT')
            @endif

            {!! $fields !!}

            <div>
                <button class="uk-button uk-button-primary">ذخیره</button>
            </div>
        </form>
    </div>
@stop