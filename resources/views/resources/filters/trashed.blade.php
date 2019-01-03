<div>
    <label>زباله</label>
    <div class="body">
        <select class="uk-select" name="FilterTrashed">
            @foreach($FilterTrashed as $key=>$value)
                <option @if(request()->{$ResourceRequest->resourceClass.'_FilterTrashed'} == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[data-resource="{{ $ResourceRequest->resourceClass }}"] [name="FilterTrashed"]').change(function () {
            var param = setParameters([{name: '{{ $ResourceRequest->resourceClass }}_FilterTrashed', value: $('[data-resource="{{ $ResourceRequest->resourceClass }}"] [name="FilterTrashed"]')
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