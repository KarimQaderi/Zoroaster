<div class="resource-ajax"
     data-route="{{ route('Zoroaster.resource-ajax.index.relationship') }}"
     data-resource="{{ class_basename($resource) }}"
     data-getKeyName="{{ $resource->newModel()->getKeyName() }}"
     data-isForceDeleting="{{ method_exists($resource->newModel(), 'isForceDeleting') }}"
     data-viaRelationshipFieldName="{{ $field->name  }}"
     data-viaRelationship="{{ $resourceRequest->resourceClass  }}"
     data-viaResourceId="{{ $data->id  }}"
     data-relationshipType="HasOne"


>
    <script>
        $(document).ready(function () {
            index_resources('{{ class_basename($resource) }}');
        });
    </script>
</div>
