@empty(!$data)
    <div class="row RowOneCol {{ isset($field->class)?'uk-grid  '.$field->class : ''}} panel">
            {!! $data !!}
    </div>
@endempty
