@empty(!$builder->data)
    <div class="uk-grid row {{ $builder->class }}">
        {!! $builder->data !!}
    </div>
@endempty
