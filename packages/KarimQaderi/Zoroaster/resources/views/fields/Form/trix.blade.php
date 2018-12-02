<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
</label>
<input id="{{ $field->name }}" name="{{ $field->name}}" value="{{ $data->{$field->name} ?? null }}" type="hidden">
<trix-editor input="{{ $field->name }}"></trix-editor>