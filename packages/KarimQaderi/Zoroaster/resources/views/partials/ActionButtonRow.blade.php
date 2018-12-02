{{--@foreach($ActionButtonRow as $btn)--}}
{{--<a--}}
{{--@foreach(isset($btn['attr'])? $btn['attr'] : [] as $_key=>$_value)--}}
{{--{{ $_key }}="{{ $_value }}"--}}
{{--@endforeach--}}
{{--href="{{ route($btn['route'],$value->{$key}) }}">{{ $btn['label'] }}</a>--}}
{{--@endforeach--}}

    <a href="{{ route('Zoroaster.resource.show',['resoure'=> $request->resoureClass,'resourceId'=> $data->{$model->getKeyName()}]) }}" class="uk-icon">
        <svg width="22" height="18" viewBox="0 0 22 16">
            <path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
        </svg>
    </a>

    <a href="{{ route('Zoroaster.resource.edit',['resoure'=> $request->resoureClass,'resourceId'=> $data->{$model->getKeyName()}]) }}" class="uk-icon">
        <svg width="20" height="20" viewBox="0 0 20 20">
            <path d="M4.3 10.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM6 14h2.59l9-9L15 2.41l-9 9V14zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h6a1 1 0 1 1 0 2H2v14h14v-6z"></path>
        </svg>
    </a>


<button class="uk-icon delete-one-resource" resourceId="{{ $data->{$model->getKeyName()} }}">
    <svg width="20" height="20" viewBox="0 0 20 20">
        <path fill-rule="nonzero"
              d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path>
    </svg>
</button>