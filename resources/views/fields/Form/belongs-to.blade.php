
<label>
    <span class="label">{{ $field->label }}</span>
    <select class="uk-select" name="{{ $field->name }}">
        @foreach($all as $item)
            <option
                    @if (old($field->name)!==null)
                    @if (old($field->name)==$item->{$foreign_key}) selected @endif
                    @else
                    @if ($value!==null && $value->{$foreign_key}==$item->{$foreign_key}) selected @endif
                    @endif
                    value="{{ $item->{$foreign_key} }}">{{ $item->{$field->display} }}</option>
        @endforeach
    </select>
</label>