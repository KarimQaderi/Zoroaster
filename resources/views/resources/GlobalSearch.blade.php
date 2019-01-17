<label>{{ $newResource->singularLabel }}</label>
@forelse($data as $item)
    <a class="item" href="{{ route('Zoroaster.resource.show',['resource'=> class_basename($newResource),'resourceId'=> $item->{$model->getKeyName()}]) }}">{{ $item->{$newResource->title} }}</a>
@empty
    <div class="NoItem">چیزی پیدا نشد</div>
@endforelse