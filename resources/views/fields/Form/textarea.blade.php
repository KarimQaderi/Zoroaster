<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <textarea rows="{{ Zoroaster::getMeta($field,'rows') }}" name="{{ $field->name }}" class="uk-textarea">{{ (old($field->name)===null)? $value ?? null : old($field->name) }}</textarea>
</label>