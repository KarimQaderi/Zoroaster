<label>
    <span class="label">{{ $field->label }}</span>
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <input class="uk-input" name="{{ $field->name }}" type="text" value="{{ old($field->name,(is_array($value))? json_encode($value) : $value) }}">
</label>