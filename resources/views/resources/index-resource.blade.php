@if(count($resources) != 0)
    <table class="uk-table dataTables uk-table-middle">
        <thead>
        <tr role="row">
            <th></th>
            @foreach($fields as $field)
                <th data-sortable_field="{{ $field->name }}" data-sortable="{{ (request()->{$ResourceRequest->resourceClass . '_sortable_field'} == $field->name)? request()
                        ->{$ResourceRequest->resourceClass . '_sortable_direction'} : '' }}"
                    class=" {{ $field->sortable? 'cursor-pointer': ''}}"
                    style="width: 59px;text-align: {{ $field->textAlign }}">{{ $field->label }}
                    @if ($field->sortable == true)
                        <div class="sortable">
                            <span uk-icon="cheveron-up"></span>
                            <span uk-icon="cheveron-down" cheveron-checked="1"></span>
                        </div>
                    @endif
                </th>
            @endforeach
            <th style="width: 134px;text-align: center">
                عملیات
            </th>
        </tr>
        </thead>
        <tbody>

        @foreach($resources as $data)

            @php($ResourceRequest->Resource()->resource = $data)

            <tr destroy-resourceId="{{ $data->{$model->getKeyName()} }}">
                <td style="width: 32px;">
                    <input name="{{ $model->getKeyName() }}[]" value="{{ $data->{$model->getKeyName()} }}"
                           class="uk-checkbox key_dataTable_2 key_dataTable_{{ $model->getKeyName() }}"
                           type="checkbox">
                </td>

                @foreach($fields as $field)
                    <td style="text-align: {{ $field->textAlign }}" class="uk-text-nowrap">{!! $field->viewIndex($field,$data,$ResourceRequest) !!}</td>
                @endforeach

                <td class="action_btn" style="text-align: center">
                    {!! Zoroaster::ResourceActions($ResourceRequest->Resource(),$data,$model,'Index',$field) !!}
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>

    @if(!(isset($relationshipType) && $relationshipType=='HasOne'))
        @include('Zoroaster::paginate.resources')
    @endif

@else
    <div class="noCountResources">
        <span uk-icon="icon: plus-circle; ratio: 2"></span>
        <div class="text">هیچ {{ $resourceClass->singularLabel }}ی پیدا نشد</div>
        <a href="{{ route('Zoroaster.resource.create',['resoure'=> $ResourceRequest->resourceClass]) }}" class="btn uk-button uk-button-primary uk-border-rounded">اضافه
            کردن {{ $resourceClass->singularLabel }}</a>
    </div>
@endif

