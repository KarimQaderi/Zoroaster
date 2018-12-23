@empty(!$data)
    <div class="panel {{ $field->class }}">
        @empty(!$field->name)
            <h3>{{ $field->name }}</h3>
        @endempty
        {!! $data !!}
    </div>
@endempty