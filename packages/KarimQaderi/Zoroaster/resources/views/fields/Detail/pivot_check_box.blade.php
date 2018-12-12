<div class="pivot_check_box">
    <span class="label">{{ $field->label }} : </span>&nbsp;
    <br>
    <br>
    @foreach($pivot as $item)
        {{ $item['name'] }} @if(!$loop->last) , @endif
    @endforeach
</div>