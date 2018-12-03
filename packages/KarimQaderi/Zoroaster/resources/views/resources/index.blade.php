@extends('Zoroaster::layout')

@section('content')
    <div class="uk-card card">

        <h1 class="resourceName">{{ $resourceClass->labels }}</h1>
        <div class="uk-child-width-1-2 resourceName_2" uk-grid>
            <div>
                <form class="uk-search">
                    <button uk-search-icon></button>
                    <input class="uk-search-input" type="search" name="search" value="{{ request()->search }}" placeholder="Search...">
                </form>
            </div>
            <div class="uk-text-left">
                <a href="{{ route('Zoroaster.resource.create',['resoure'=> $request->resourceClass]) }}" class="btn uk-button uk-button-primary uk-border-rounded">اضافه
                    کردن {{ $resourceClass->label }}</a>
            </div>
        </div>
        <div class="card-w">
            @if(count($resources) != 0)

                <div class="uk-child-width-1-2 resourceName_3" uk-grid>
                    <div>
                        <div class="select_row uk-icon">
                            <input class="uk-checkbox key_dataTable" type="checkbox">
                        </div>
                    </div>
                    <div class="uk-text-left">

                        <div class="uk-display-inline-block">
                            <div class="filter-selector bg-hover uk-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="filter" role="presentation" class="fill-current text-80">
                                    <path fill-rule="nonzero"
                                          d="M.293 5.707A1 1 0 0 1 0 4.999V1A1 1 0 0 1 1 0h18a1 1 0 0 1 1 1v4a1 1 0 0 1-.293.707L13 12.413v2.585a1 1 0 0 1-.293.708l-4 4c-.63.629-1.707.183-1.707-.708v-6.585L.293 5.707zM2 2v2.585l6.707 6.707a1 1 0 0 1 .293.707v4.585l2-2V12a1 1 0 0 1 .293-.707L18 4.585V2H2z"></path>
                                </svg>
                                <svg width="10px" height="6px" viewBox="0 0 10 6" version="1.1" xmlns="http://www.w3.org/2000/svg" class="ml-2">
                                    <g stroke="none" stroke-width="1" fill-rule="evenodd">
                                        <g id="04-user" transform="translate(-385.000000, -573.000000)" fill-rule="nonzero">
                                            <path d="M393.292893,573.292893 C393.683418,572.902369 394.316582,572.902369 394.707107,573.292893 C395.097631,573.683418 395.097631,574.316582 394.707107,574.707107 L390.707107,578.707107 C390.316582,579.097631 389.683418,579.097631 389.292893,578.707107 L385.292893,574.707107 C384.902369,574.316582 384.902369,573.683418 385.292893,573.292893 C385.683418,572.902369 386.316582,572.902369 386.707107,573.292893 L390,576.585786 L393.292893,573.292893 Z"
                                                  id="Path-2-Copy">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div uk-dropdown="mode: click">
                                @include('Zoroaster::resources.filters.perPage')
                            </div>
                        </div>

                        <div class="filter-selector bg-hover uk-icon delete-one-resource-multi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="delete" role="presentation" class="fill-current text-80">
                                <path fill-rule="nonzero"
                                      d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path>
                            </svg>
                        </div>

                    </div>
                </div>

                <table class="uk-table dataTables uk-table-middle">
                    <thead>
                    <tr role="row">
                        <th></th>
                        @foreach($fields as $field)
                            <th data-column="row" class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="#مرتب سازی از بزرگ به کوچک"
                                style="width: 59px;text-align: {{ $field->textAlign }}">{{ $field->label }}
                            </th>
                        @endforeach
                        <th data-column="oper" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="عملیاتمرتب سازی از کوچک به بزرگ"
                            style="width: 134px;text-align: center">
                            عملیات
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($resources as $data)
                        <tr destroy-resourceId="{{ $data->{$model->getKeyName()} }}">
                            <td style="width: 32px;">
                                <input name="{{ $model->getKeyName() }}[]" value="{{ $data->{$model->getKeyName()} }}" class="uk-checkbox key_dataTable_2 key_dataTable_{{ $model->getKeyName() }}"
                                       type="checkbox">
                            </td>
                            @foreach($fields as $field)

                                <td style="text-align: {{ $field->textAlign }}" class="uk-text-nowrap">{!! $field->viewIndex($data,$field) !!}</td>

                            @endforeach
                            <td class="action_btn" style="text-align: center">
                                {!! Zoroaster::ResourceActions($request,$data,$model,'Index',$field) !!}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="dataTables_info uk-child-width-1-3" uk-grid>
                    <div class="dataTables_paginate">
                        @if ($resources->onFirstPage())
                            <li><a href="{{ $resources->previousPageUrl() }}"><span class="uk-margin-small-right" uk-pagination-previous></span> قبلی</a></li>
                        @endif
                    </div>
                    <div class="uk-text-center"> نمایش {{ $resources->firstItem() }} تا {{ $resources->lastItem() }} از {{ $resources->total() }}
                        رکورد
                    </div>
                    <div class="uk-text-left">
                        @if ($resources->hasMorePages())
                            <li class="uk-margin-auto-left">
                                <a href="{{ $resources->nextPageUrl() }}">بعدی <span class="uk-margin-small-left" uk-pagination-next></span></a>
                            </li>
                        @endif
                    </div>
                </div>

            @else
                <div class="noCountResources">
                    <span uk-icon="icon: plus-circle; ratio: 2"></span>
                    <div class="text">هیچ {{ $resourceClass->label }}ی پیدا نشد</div>
                    <a href="{{ route('Zoroaster.resource.create',['resoure'=> $request->resourceClass]) }}" class="btn uk-button uk-button-primary uk-border-rounded">اضافه
                        کردن {{ $resourceClass->label }}</a>
                </div>
            @endif

        </div>
    </div>


    <script>

        $(document).ready(function () {
            $(document).on('change', '.key_dataTable', function () {

                if ($(this).is(':checked'))
                    $('.key_dataTable_{{ $model->getKeyName() }}').prop('checked', true);
                else
                    $('.key_dataTable_{{ $model->getKeyName() }}').prop('checked', false);


            });

            $(document).on('click', '.delete-one-resource', function () {

                $this = $(this);

                UIkit.modal.confirm(
                    '<h2>حذف رکورد</h2>' +
                    '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
                    , {labels: {ok: 'حذف', cancel: 'خیر'}}).then(function () {
                    Destroy([$this.attr('resourceId')]);
                });

            });

            $(document).on('click', '.delete-one-resource-multi', function () {

                var arrResourceId = [];

                $('.key_dataTable_{{ $model->getKeyName() }}:checked').each(function () {
                    arrResourceId.push(this.value);
                });

                UIkit.modal.confirm(
                    '<h2>حذف رکورد ها</h2>' +
                    '<h3>شما دارید این  رکورد ها رو حذف می کنید مطمئن هستید</h3>'
                    , {labels: {ok: 'حذف', cancel: 'خیر'}}).then(function () {
                    Destroy(arrResourceId);
                });

            });
        });


        function Destroy($resourceId) {
            $destroy_resourceId = $resourceId;

            $.each($destroy_resourceId, function (_key, _value) {
                $('[destroy-resourceId="' + _value + '"]').addClass('destroy-resourceid');
            });

            $.ajax({
                type: 'DELETE',
                url: '{{ route('Zoroaster.resource.destroy',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId
                },
                success: function (data) {
                    console.log(data);
                    $.each($destroy_resourceId, function (_key, _value) {
                        $('[destroy-resourceId="' + _value + '"]').remove();
                    });

                },
                error: function (data) {

                    var errors = data.responseJSON;
                    console.log(errors.errors);

                    // $.each(errors.errors, function (key, item) {
                    //     errorsHtml += '<li>' + item + '</li>'; //showing only the first error.
                    // });

                }
            });
        }


    </script>

@endsection