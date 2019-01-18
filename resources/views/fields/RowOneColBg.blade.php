@empty(!$data)
    <div class="uk-grid row RowOneCol {{ empty($field->class)?'uk-width-1-1' : $field->class }} panel">
            {!! $data !!}
    </div>
@endempty
