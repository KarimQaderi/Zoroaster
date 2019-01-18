<div class="{{ $getKey }} filter_render">
    <label>{{ $label }}</label>
    <div class="body">
        {!! $render !!}
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.{{ $getKey }} select').change(function () {
            var param = setParameters([{name: '{{ $getKey }}', value: $('.{{ $getKey }} select')
                    .find(':selected').val()}]);
            $this = $('[data-resource="{{ $ResourceRequest->resourceClass }}"]');


            param.push({name: 'resource', value: '{{ $ResourceRequest->resourceClass }}'});

            $this.html("<span uk-icon=\"load\"></span>");

            ajaxGET($this.attr('data-route'), mergeArray(param, get_data_index_resources('{{ $ResourceRequest->resourceClass }}')),
                function (data) {
                    $('[data-resource="' + data.resource + '"]').html(data.render);
                },
                function (data) {
                    var errors = data.responseJSON;
                }
            );
        });
    });
</script>