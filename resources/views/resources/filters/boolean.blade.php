<div class="{{ $getKey }}">
    <label>{{ $label }}</label>
    <div class="body">
        {!! $boolean !!}
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.{{ $getKey }} [type="checkbox"]').click( function () {
            var param = [];
            @foreach($keys as $key)
            param.push({name: '{{ $key }}', value: $('[name="{{ $key }}"]').is(':checked')});
            @endforeach

            setParameters(param);

            index_resources('{{ $resource->uriKey() }}');

        });
    });
</script>