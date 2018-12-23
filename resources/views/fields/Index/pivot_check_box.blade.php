<div class="pivot_check_box">
    @foreach($pivot as $item)
        <span class="uk-label uk-label-success">{{ $item['name'] }}</span> @if(!$loop->last) , @endif
    @endforeach
</div>