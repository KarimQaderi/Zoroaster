<label>
    <span class="label">{{ $field->label }}</span>
    <div class="body">{{ Zoroaster::getOptionsSelect($field,$value,'label') }}</div>
</label>

<script>

    var {{ $field->name.time() }}_hiden_element = @json(Zoroaster::getMeta($field,'activeEelementByClass') );
    activeEelementByClass({{ $field->name.time() }}_hiden_element);

    $select = $('.{{ $field->name.time() }}').find(':selected').val();
    $('.' + activeEelementByClassFind({{ $field->name.time() }}_hiden_element,$select)).removeClass('hidden');

    $(document).ready(function () {
        $(document).on('change', '.{{ $field->name.time() }}', function () {
            $select = $('.{{ $field->name.time() }}').find(':selected').val();
            activeEelementByClass({{ $field->name.time() }}_hiden_element);

            $('.' + activeEelementByClassFind({{ $field->name.time() }}_hiden_element,$select)).removeClass('hidden');

        });
    });

</script>