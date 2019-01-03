@empty($field->routeShow)
    {{ $value }}
@else
    @empty($data)
        چیزی پیدا نشد
    @else
        <a href="{{ route($field->routeShow,['resource'=>\Zoroaster::getNameResourceByModelName($field->model),'resourceId'=>$data_relation->{$foreign_key}]) }}">{{ $value }}</a>
    @endif
@endempty