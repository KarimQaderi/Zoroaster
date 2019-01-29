<label>
    <span class="label">{{ $field->label }}</span>
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <input @if (old($field->name ,$value)==true) checked @endif name="{{ $field->name }}" class="uk-checkbox" type="checkbox">
</label>