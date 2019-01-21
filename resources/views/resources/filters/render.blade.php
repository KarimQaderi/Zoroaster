<div class="{{ $getKey }} filter_render">
    <label>{{ $label }}</label>
    <div class="body">
        {!! $render !!}
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.{{ $getKey }} select').change(function () {

            setParameters([{name: '{{ $getKey }}', value: $('.{{ $getKey }} select').find(':selected').val()}]);

            index_resources('{{ $resource->uriKey() }}');

        });
    });
</script>