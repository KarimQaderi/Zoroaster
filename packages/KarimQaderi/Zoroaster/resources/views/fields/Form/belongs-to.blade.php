<label>
    <span class="label">{{ $field->label }}</span>
    <select class="uk-select" name="{{ $field->name }}">
        @foreach($all as $item)
            <option
                    @if (old($field->name)!==null)
                    @if (old($field->name)==$item->{$field->foreign_key}) selected @endif
                    @else
                    @if ($data!==null && $data->{$field->foreign_key}==$item->{$field->foreign_key}) selected @endif
                    @endif
                    value="{{ $item->{$field->foreign_key} }}">{{ $item->{$field->displayTitleField}
            }}</option>
        @endforeach
    </select>
</label>