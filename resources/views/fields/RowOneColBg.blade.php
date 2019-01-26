@empty(!$builder->data)
    <div class="row RowOneCol {{ isset($builder->class)?'uk-grid  '.$builder->class : ''}} panel">
            {!! $builder->data !!}
    </div>
@endempty
