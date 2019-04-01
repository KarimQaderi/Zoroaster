<label>
    <span class="label">{{ $field->label }}</span>
    <div hidden><textarea name="{{ $field->name }}">{{ $value }}</textarea></div>
    <div showName="{{ $field->name }}"></div>
</label>

<script>
    SimpleMDE = SimpleMDE.prototype.markdown($('[name="{{ $field->name }}"]').val());
    $('[showName="{{ $field->name }}"]').html(SimpleMDE);
</script>
