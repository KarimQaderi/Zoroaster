<label>
    <span class="label">{{ $field->label }}</span>
    <div class="body">
        @empty($data)
            چیزی پیدا نشد
        @else
            {{ $value }}
        @endempty
    </div>
</label>