<label>
    <span class="label">{{ $field->label }}</span>
    <div class="body">{{ Zoroaster::getOptionsSelect($field,$value,'label') }}</div>
</label>


@empty(!Zoroaster::getMeta($field,'activeEelementByClass'))
    <script>
        $(document).ready(function () {
            var {{ $field->name.time() }}_hiden_element = @json(Zoroaster::getMeta($field,'activeEelementByClass') );
            activeEelementByClass({{ $field->name.time() }}_hiden_element);

            $select = $('.{{ $field->name.time() }}').find(':selected').val();
            $('.' + activeEelementByClassFind({{ $field->name.time() }}_hiden_element, $select)).removeClass('hidden');

            $(document).ready(function () {
                $(document).on('change', '.{{ $field->name.time() }}', function () {
                    $select = $('.{{ $field->name.time() }}').find(':selected').val();
                    activeEelementByClass({{ $field->name.time() }}_hiden_element);

                    $('.' + activeEelementByClassFind({{ $field->name.time() }}_hiden_element, $select)).removeClass('hidden');

                });
            });
        });
    </script>
@endempty

@empty(!Zoroaster::getMeta($field,'showDataByOptionSelected'))
    <script>
        $(document).ready(function () {

            f_{{ $field->name.time() }}();
            $(document).on('change', '.{{ $field->name.time() }}', function () {
                f_{{ $field->name.time() }}();
            });
        });

        function f_{{ $field->name.time() }}() {
            $select = $('.{{ $field->name.time() }}').find(':selected').val();

            $.ajax({
                type: 'GET',
                url: '{{ route(Zoroaster::getMeta($field,'route')) }}',
                data: {
                    select: $select
                },
                success: function (data) {
                    $('.{{ Zoroaster::getMeta($field,'class') }}').html(data);
                }
            });
        }
    </script>
@endempty