<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <input class="uk-input" name="{{ $field->name }}" type="password" value="{{ old($field->name) }}">
    {{--<input class="uk-input" name="{{ $field->name }}_confirmation" type="password" value="{{ old($field->name.'_confirmation') }}">--}}
</label>