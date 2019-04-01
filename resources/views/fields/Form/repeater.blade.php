{!! $render !!}

@if(!is_bool($repeaterScript))
    {!! $renderTemplate !!}
@endif

<script>

    @if(is_null($repeaterScript) && !is_array($repeaterScript) && !is_bool($repeaterScript))
    $(document).ready(function () {
        $('.{{ $name }}').repeater({!! $repeatersJS !!});
    });
    @endif

    @if(is_array($repeaterScript))
    $(document).ready(function () {
        $('.{{ $name }}').repeater(@json($repeaterScript));
    });

    @endif

    @if(is_string($repeaterScript))
    $(document).ready(function () {
        $('.{{ $name }}').repeater({!! $repeaterScript !!});
    });
    @endif

</script>



