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

            param.push({name: 'resource', value: '{{ $ResourceRequest->resourceClass }}'});

            $('[data-resource="{{ $ResourceRequest->resourceClass }}"]').html("<span uk-icon=\"load\"></span>");

            ajaxGET(Zoroaster_resource_ajax_index, param,
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