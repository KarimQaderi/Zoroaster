<div class="resource-ajax"
     data-route="{{ route('Zoroaster.resource-ajax.index') }}"
     data-resource="{{ $resource->uriKey() }}"
     data-getKeyName="{{ $resource->resource->getKeyName() }}"
     data-isForceDeleting="{{ method_exists($resource->resource, 'isForceDeleting') }}"
>
    <div class="uk-card">

        <h1 class="resourceName">{{ $resource->label }}</h1>
        <div class="uk-child-width-1-2 resourceName_2" uk-grid>
            <div>
                <div class="uk-search search">
                    <button uk-search-icon></button>
                    <input class="uk-search-input" type="search" name="search" value="{{ request()->{$resource->uriKey().'_search'} }}" placeholder="جستجو ...">
                </div>
            </div>
            <div class="uk-text-left">
                @if ($resource->authorizedToCreate($resource->newModel()))
                    <a href="{{ route('Zoroaster.resource.create',['resoure'=> $resource->uriKey()]) }}" class="btn uk-button uk-button-primary uk-border-rounded">اضافه
                        کردن {{ $resource->singularLabel }}</a>
                @endif
            </div>
        </div>
        <div class="card-w">
            <div class="uk-child-width-1-2 resourceName_3" uk-grid>
                <div>
                    <div class="select_row uk-icon">
                        <input class="uk-checkbox key_dataTable" type="checkbox">
                    </div>
                </div>
                <div class="uk-text-left ResourceActions_dataTables">

                    <div class="uk-display-inline-block">
                        <div class="filter-selector bg-hover uk-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="filter" role="presentation"
                                 class="fill-current text-80">
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

                            {!! Zoroaster::Filters($resource) !!}

                        </div>
                    </div>

                    {!! Zoroaster::ResourceActions($resource,$resource->newModel(),$resource->newModel(),'IndexTopLeft',null) !!}

                </div>
            </div>

            <div class="data_table"></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            index_resources('{{ $resource->uriKey() }}');
        });
    </script>
</div>
