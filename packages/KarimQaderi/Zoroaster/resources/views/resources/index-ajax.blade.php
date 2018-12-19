<div class="resource-ajax"
     data-resource="{{ class_basename($resource) }}"
     data-getKeyName="{{ $resource->newModel()->getKeyName() }}"
     data-isForceDeleting="{{ method_exists($resource->newModel(), 'isForceDeleting') }}"

>
    <script>
        $(document).ready(function () {
            index_resources('{{ class_basename($resource) }}');
        });
    </script>
</div>
