<div class="resource-ajax"
     data-resource="{{ class_basename($resource) }}"
     data-getKeyName="{{ Zoroaster::newModel($resource->model)->getKeyName() }}"
     data-isForceDeleting="{{ method_exists(Zoroaster::newModel($resource->model), 'isForceDeleting') }}"

>
    <script>
        $(document).ready(function () {
            index_resources('{{ class_basename($resource) }}');
        });
    </script>
</div>
