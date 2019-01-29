<div class="{{ $getKey }} filter_render">
    <label>{{ $label }}</label>
    <div class="body">
        {!! $render !!}
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.{{ $getKey }} input').change(function () {

            setParameters([{name: '{{ $getKey }}', value: $('.{{ $getKey }} input').val()}]);

            index_resources('{{ $resource->uriKey() }}');
        });
    });
</script>