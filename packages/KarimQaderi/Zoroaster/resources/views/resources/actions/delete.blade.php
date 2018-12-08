<button uk-icon="delete" class="uk-icon @if (array_key_exists('deleted_at',$data->attributesToArray())) softDeleting @else ForceDeleting @endif delete-one-resource action--delete" resourceId="{{
$data->{$model->getKeyName
()} }}"></button>

@if($view == 'Detail')

    <script>

        $(document).ready(function () {

            $(document).on('click', '.delete-one-resource', function () {

                $this = $(this);

                UIkit.modal.confirm(
                    '<h2>حذف رکورد</h2>' +
                    '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
                    , {labels: {ok: 'حذف', cancel: 'خیر'}}).then(function () {
                    DestroyOne($this.attr('resourceId'));
                });

            });


        });

        function DestroyOne($resourceId) {
            $destroy_resourceId = $resourceId;


            $.ajax({
                type: 'DELETE',
                url: '{{ route('Zoroaster.resource.destroy',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId,
                },
                success: function (data) {
                    UIkit.modal.alert('رکورد مورد نظر حذف شد').then(function () {
                        window.location.href='{{ route('Zoroaster.resource.index',['resource'=> $request->resourceClass ]) }}';
                    });

                },
                error: function (data) {



                }
            });
        }


    </script>
@endif