@empty(!$builder->data)

    <?php
    $att = '';
    foreach ($builder->att as $key => $val) {
        $att .= $key . "='" . $val . "' ";
    }
    ?>

    <div class="panel {{ $builder->class }}" {!! $att !!}>
        @empty(!$builder->name)
            <h3>{{ $builder->name }}</h3>
        @endempty
        {!! $builder->data !!}
    </div>
@endempty
