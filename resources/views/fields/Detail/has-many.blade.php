<div class="resource-ajax"
     data-route="{{ route('Zoroaster.resource-ajax.index.relationship') }}"
     data-resource="{{ $resource->uriKey() }}"
     data-getKeyName="{{ $resource->newModel()->getKeyName() }}"
     data-isForceDeleting="{{ method_exists($resource->newModel(), 'isForceDeleting') }}"
     data-viaRelationshipFieldName="{{ $field->name  }}"
     data-viaRelationship="{{ $resourceRequest->resourceClass  }}"
     data-viaResourceId="{{ $data->id  }}"
     data-relationshipType="HasMany"


>
    <script>
        $(document).ready(function () {
            index_resources('{{ $resource->uriKey() }}');
        });
    </script>
</div>
