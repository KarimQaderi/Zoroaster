<div>
    <label>تعداد در هر صفحه</label>
    <div class="body">
        <select class="uk-select" name="perPage">
            @foreach($perPages as $perPage)
                <option @if(request()->{$ResourceRequest->resourceClass.'_perPage'} == $perPage) selected @endif value="{{ $perPage }}">{{ $perPage }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('[data-resource="{{ $ResourceRequest->resourceClass }}"] [name="perPage"]').change(function () {
            var param = setParameters([{name: '{{ $ResourceRequest->resourceClass }}_perPage', value: $('[data-resource="{{ $ResourceRequest->resourceClass }}"] [name="perPage"]')
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