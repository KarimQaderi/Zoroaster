<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <div class="body">{{ Zoroaster::getOptionsSelect($field,$data->{$field->name},'label') }}</div>
</label>