<div class="pivot_check_box">
    @foreach($pivot as $item)
            {{ $item['name'] }} @if(!$loop->last) , @endif
    @endforeach
</div>