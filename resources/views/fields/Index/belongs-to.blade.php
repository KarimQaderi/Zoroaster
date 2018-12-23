@empty($field->routeShow)
    {{ $data->{$field->displayTitleField} }}
@else
    @empty($data)
        چیزی پیدا نشد
    @else
        <a href="{{ route($field->routeShow,['resource'=>\Zoroaster::getNameResourceByModelName($field->model),'resourceId'=>$data->{$field->foreign_key}]) }}">{{ $data->{$field->displayTitleField} }}</a>
    @endif
@endempty