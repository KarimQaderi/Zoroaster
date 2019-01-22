<div class="dataTables_info uk-child-width-1-3" uk-grid>
    <div class="dataTables_paginate">
        @if (!$data->onFirstPage())
            <a href="{{ $data->previousPageUrl() }}"><span class="uk-margin-small-right uk-margin-small-left"
                                                           uk-pagination-previous></span> قبلی
            </a>
        @endif
    </div>
    <div class="uk-text-center"> نمایش {{ $data->firstItem() }} تا {{ $data->lastItem() }} از {{ $data->total() }}
        رکورد
    </div>
    <div class="uk-text-left dataTables_paginate">
        @if ($data->hasMorePages())
            <a href="{{ $data->nextPageUrl() }}">بعدی <span class="uk-margin-small-left uk-margin-small-right"
                                                            uk-pagination-next></span></a>
        @endif
    </div>
</div>