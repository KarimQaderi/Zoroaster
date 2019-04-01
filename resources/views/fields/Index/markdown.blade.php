<div hidden><textarea name="{{ $field->name }}">{{ $value }}</textarea></div>
<div showName="{{ $field->name }}"></div>

<script>
    SimpleMDE = SimpleMDE.prototype.markdown($('[name="{{ $field->name }}"]').val());
    $('[showName="{{ $field->name }}"]').html(SimpleMDE);
</script>
