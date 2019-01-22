<div class="dataTables_info uk-child-width-1-3" uk-grid>
    <div class="dataTables_paginate">
        @if (!$resources->onFirstPage())
            <div data-page="{{ $resources->currentPage()-1 }}"><span class="uk-margin-small-right uk-margin-small-left"
                                                                     uk-pagination-previous></span> قبلی
            </div>
        @endif
    </div>
    <div class="uk-text-center"> نمایش {{ $resources->firstItem() }} تا {{ $resources->lastItem() }} از {{ $resources->total() }}
        رکورد
    </div>
    <div class="uk-text-left dataTables_paginate">
        @if ($resources->hasMorePages())
            <div data-page="{{ $resources->currentPage()+1 }}">بعدی <span class="uk-margin-small-left uk-margin-small-right"
                                                                          uk-pagination-next></span></div>
        @endif
    </div>
</div>