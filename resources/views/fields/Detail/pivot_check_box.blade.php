<div class="pivot_check_box">
    <span class="label">{{ $field->label }} : </span>
    <br>
    <br>
    @foreach($pivot as $item)
        <span class="uk-label uk-label-success">{{ $item['name'] }}</span> @if(!$loop->last) , @endif
    @endforeach
</div>