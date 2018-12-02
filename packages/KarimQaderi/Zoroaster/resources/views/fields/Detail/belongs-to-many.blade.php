<label>
    <span class="label">{{ $field->label }}</span>
    <select class="uk-select">
        @foreach($all as $item)
            <option @if ($data->{$field->foreign_key}==$item->{$field->foreign_key}) selected @endif value="{{ $item->{$field->foreign_key} }}">{{ $item->{$field->name} }}</option>
        @endforeach
    </select>
</label>