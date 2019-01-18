<label>
    <span class="label">{{ $field->label }}</span>
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <select class="uk-select {{ $field->name.time() }}" name="{{ $field->name }}">
        @foreach(Zoroaster::getMeta($field,'options')  as $item)
            <option
                    @if (old($field->name)!==null)
                    @if (old($field->name)==$item['value']) selected @endif
                    @else
                    @if (isset($value) && $value==$item['value']) selected @endif
                    @endif
                    value="{{ $item['value'] }}">{{ $item['label']  }}</option>
        @endforeach
    </select>
</label>

@empty(!Zoroaster::getMeta($field,'activeEelementByClass'))
    <script>

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

    </script>
@endempty