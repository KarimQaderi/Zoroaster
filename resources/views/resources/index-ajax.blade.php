<div class="resource-ajax"
     data-route="{{ route('Zoroaster.resource-ajax.index') }}"
     data-resource="{{ $resource->uriKey() }}"
     data-getKeyName="{{ $resource->resource->getKeyName() }}"
     data-isForceDeleting="{{ method_exists($resource->resource, 'isForceDeleting') }}"
>
    <script>
        $(document).ready(function () {
            index_resources('{{ $resource->uriKey() }}');
        });
    </script>
</div>
