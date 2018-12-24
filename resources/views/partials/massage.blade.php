@if (isset($errors) && $errors->any())
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@foreach(['success','error'] as $_massage)
    @php($txt_massage=Session::get($_massage))
    @if($txt_massage !== null)

        @if(is_array($txt_massage))
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <ul>
                    @foreach ($txt_massage as $massage)
                        <li>{!! $massage !!}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <script>
                UIkit.notification({message: '{!! $txt_massage !!}', status: '{{ $_massage }}'})
            </script>
        @endif

    @endisset
@endforeach