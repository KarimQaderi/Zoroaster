<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
</label>
<input id="{{ $field->name }}" name="{{ $field->name}}" value="{{ (old($field->name)===null)? $data->{$field->name} ?? null : old($field->name) }}" type="hidden">
<trix-editor input="{{ $field->name }}"></trix-editor>