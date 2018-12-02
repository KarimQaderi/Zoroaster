<label>
    <span class="label">{{ $field->label }}</span>
    <select class="uk-select" name="{{ $field->name }}">
        @foreach($all as $item)
            <option @if ($data!==null && $data->{$field->foreign_key}==$item->{$field->foreign_key}) selected @endif value="{{ $item->{$field->foreign_key} }}">{{ $item->{$field->displayTitleField}
            }}</option>
        @endforeach
    </select>
</label>