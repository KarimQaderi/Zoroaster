@foreach($ActionButtonRow as $btn)
    <a
            @foreach(isset($btn['attr'])? $btn['attr'] : [] as $_key=>$_value)
                   {{ $_key }}="{{ $_value }}"
            @endforeach
            href="{{ route($btn['route'],$value->{$key}) }}">{{ $btn['label'] }}</a>
@endforeach
