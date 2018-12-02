<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <input class="uk-input" name="{{ $data->name }}" type="file" value="{{ $data->{$field->name} }}">
</label>