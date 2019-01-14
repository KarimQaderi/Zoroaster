@empty($field->routeShow)
    {{ $value }}
@else
    @if(is_null($data) || is_null($data_relation))
        چیزی پیدا نشد
    @else
        <a href="{{ route($field->routeShow,['resource'=>\Zoroaster::newResourceByModelName($field->model)->uriKey(),'resourceId'=>$data_relation->{$foreign_key}]) }}">{{ $value }}</a>
    @endif
@endempty

