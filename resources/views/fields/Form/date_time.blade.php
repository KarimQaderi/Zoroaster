<label>
    <span class="label">{{ $field->label }}</span>
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <input class="uk-input" name="{{ $field->name }}" type="text" value="{{ old($field->name,$value) }}">
</label>

<script>
    $('[name="{{ $field->name }}"]').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
    });
</script>