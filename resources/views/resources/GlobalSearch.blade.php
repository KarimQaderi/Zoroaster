<label>{{ $newResource->label }}</label>
@forelse($data as $item)
    @php($newResource->resource = $item)
    <a class="item" href="{{ route('Zoroaster.resource.show',['resource'=> $newResource->uriKey(),'resourceId'=> $item->{$model->getKeyName()}]) }}">
        {{ $item->{$newResource->title} }}
    </a>
    <div class="searchSubTitle">
       {!! $newResource->searchSubTitle() !!}
    </div>
@empty
    <div class="NoItem">چیزی پیدا نشد</div>
@endforelse
