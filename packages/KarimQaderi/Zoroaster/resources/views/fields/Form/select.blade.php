<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <select class="uk-select" name="{{ $field->name }}">
        @foreach(Zoroaster::getMeta($field,'options')  as $item)
            <option @if ($data->{$field->name}==$item['value']) selected @endif value="{{ $item['value'] }}">{{ $item['label']  }}</option>
        @endforeach
    </select>
</label>