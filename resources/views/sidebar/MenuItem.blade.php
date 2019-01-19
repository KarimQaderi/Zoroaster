<li class="@empty(!$item->data) uk-parent @endempty @if(str_is("*".URL::current(),$item->Link) === true ) uk-active @endif @if(str_contains($item->data,URL::current().'"')===true) uk-open @endif">
    <a href="{{ $item->Link }}"><i class="uk-margin-small-left" @empty(!$item->icon) uk-icon="{{ $item->icon }}" @endempty ></i>{{ $item->Label
    }} @isset($item->badge)<span class="uk-badge">{!! $item->badge  !!}</span>@endisset</a>
    @empty(!$item->data)
        <ul class="uk-nav-sub">
            {!! $item->data !!}
        </ul>
    @endempty
</li>