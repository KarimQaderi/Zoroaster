<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <input class="uk-input" name="{{ $field->name }}" type="number" value="{{ (old($field->name)===null)? $data->{$field->name} ?? null : old($field->name) }}">
</label>