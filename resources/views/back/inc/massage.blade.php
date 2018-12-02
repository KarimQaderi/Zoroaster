@if ($errors->any())
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php($success=Session::get('success'))
@if($success!==null)
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        @if(is_array($success))
            <ul>
                @foreach ($success as $massage)
                    <li>{!! $massage !!}</li>
                @endforeach
            </ul>
        @else
            <p>{!! $success !!}</p>
        @endif
    </div>
@endisset