@empty(!$builder->data)
    <div class="panel {{ $builder->class }}">
        @empty(!$builder->name)
            <h3>{{ $builder->name }}</h3>
        @endempty
        {!! $builder->data !!}
    </div>
@endempty