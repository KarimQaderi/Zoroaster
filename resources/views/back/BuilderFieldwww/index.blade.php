@extends('back.layouts.app')
@section('title','داشبورد')
@section('content')
    <div class="uk-card uk-padding tm-card-default">
        <div class="uk-overflow-auto">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper uk-form dt-uikit no-footer">
                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>جست&zwnj;وجو:&ensp;<input type="search" class="uk-input" placeholder="" aria-controls="DataTables_Table_0"></label>
                </div>
                <div class="dataTables_length" id="DataTables_Table_0_length"><label>نمایش &nbsp; <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="uk-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> &nbsp; سطر در هر برگه</label></div>

                <table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-table-divider data-table dataTable no-footer" id="DataTables_Table_0" role="grid"
                       aria-describedby="DataTables_Table_0_info">
                    <thead>
                    <tr role="row">
                        @foreach($fields as $field)
                            <th data-column="row" class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="#مرتب سازی از بزرگ به کوچک"
                                style="width: 59px;">{{ $field->label }}
                            </th>
                        @endforeach
                        <th data-column="oper" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="عملیاتمرتب سازی از کوچک به بزرگ"
                            style="width: 134px;">
                            عملیات
                        </th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($data as $value)
                        <tr>
                            @foreach($fields as $field)
                                <td data-column="{{ $field->name }}">@include('BuilderFields::Fields.index.'.$field->component,['data'=>$value,'field'=>$field] )</td>
                            @endforeach
                            <td>
                                @include('BuilderFields::back.BuilderField.inc.ActionButtonRow',['key'=>$primaryKey,'ActionButtonRow'=>$ActionButtonRow,'field'=>$field,'value'=>$value])
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {!! $data !!}
                </div>
                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">نمایش {{ $data->firstItem() }} تا {{ $data->lastItem() }} از {{ $data->total() }}
                    رکورد
                </div>
            </div>
        </div>
    </div>
@endsection