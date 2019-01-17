<div class="{{ $getKey }}">
    <label>{{ $name }}</label>
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

                    console.log(param);
            setParameters(param);

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