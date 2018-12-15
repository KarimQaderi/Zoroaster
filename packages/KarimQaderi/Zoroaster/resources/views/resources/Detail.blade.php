@extends('Zoroaster::layout')

@section('content')

    <div class="uk-card ">

        <div class="BuilderFields">


            <div class="uk-child-width-1-2 resourceName_2 view_Details" uk-grid>
                <div>
                    <h1 class="resourceName">مشاهدی {{ $resourceClass->label }}</h1>
                </div>
                <div class="uk-text-left ResourceActions">
                    {!! Zoroaster::ResourceActions($request,$resources,$model,'Detail',null) !!}
                </div>
            </div>

            {!! $fields !!}

        </div>
    </div>


    <script>

        $(document).on('click', '.ForceDeleting', function () {

            $this = $(this);

            UIkit.modal.confirm(
                '<h2>حذف رکورد</h2>' +
                '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
                , {
                    labels: {ok: 'حذف', cancel: 'خیر'},
                    addClass: 'modal_delete'
                }).then(function () {
                Destroy([$this.attr('resourceId')]);
            });

        });

        $(document).on('click', '.softDeleting', function () {

            $this = $(this);

            UIkit.modal.confirm(
                '<h2>حذف رکورد</h2>' +
                '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
                , {
                    labels: {ok: 'حذف', cancel: 'خیر'},
                    addClass: 'modal_delete'
                }).then(function () {
                DestroySoftDeleting([$this.attr('resourceId')]);
            });

        });

        $(document).on('click', '.restore-one-resource', function () {

            $this = $(this);

            UIkit.modal.confirm(
                '<h2>بازیابی رکورد</h2>' +
                '<h3>شما دارید این رکورد رو بازیابی می کنید مطمئن هستید</h3>'
                , {
                    labels: {ok: 'بله', cancel: 'خیر'},
                    addClass: 'modal_restore'
                }).then(function () {
                Restore([$this.attr('resourceId')]);
            });

        });

        function Destroy($resourceId) {
            $destroy_resourceId = $resourceId;

            $.ajax({
                type: 'DELETE',
                url: '{{ route('Zoroaster.resource.destroy',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId
                },
                success: function (data) {
                    UIkit.modal.alert('رکورد حذف شد',
                        {
                            labels: {ok: 'باشه'},
                            addClass: 'modal_alert'
                        }).then(function () {
                        window.location = '{{ route('Zoroaster.resource.index',['resource'=> $request->resourceClass ]) }}';
                    });

                },
                error: function (data) {

                    var errors = data.responseJSON;

                }
            });
        }

        function DestroySoftDeleting($resourceId) {
            $destroy_resourceId = $resourceId;

            $.ajax({
                type: 'POST',
                url: '{{ route('Zoroaster.resource.softDeleting',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId
                },
                success: function (data) {
                    UIkit.modal.alert('رکورد حذف شد',
                        {
                            labels: {ok: 'باشه'},
                            addClass: 'modal_alert'
                        }).then(function () {
                        location.reload();
                    });
                },
                error: function (data) {

                    var errors = data.responseJSON;
                }
            });
        }

        function Restore($resourceId) {
            $destroy_resourceId = $resourceId;

            $.ajax({
                type: 'PUT',
                url: '{{ route('Zoroaster.resource.restore',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId
                },
                success: function (data) {
                    UIkit.modal.alert('رکورد بازیابی شد',
                        {
                            labels: {ok: 'باشه'},
                            addClass: 'modal_alert'
                        }).then(function () {
                        location.reload();
                    });

                },
                error: function (data) {

                    var errors = data.responseJSON;

                }
            });
        }
    </script>
@stop