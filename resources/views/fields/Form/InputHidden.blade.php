<input  name="{{ $field->name }}"
        type="hidden"
        value="{{ old($field->name,(is_array($value))? json_encode($value) : $value) }}">