<button class="uk-icon delete-one-resource action--delete" resourceId="{{ $data->{$model->getKeyName()} }}">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 20" aria-labelledby="restore" role="presentation" class="fill-current" with="20"><path d="M3.41 15H16a2 2 0 0 0 2-2 1 1 0 0 1 2 0 4 4 0 0 1-4 4H3.41l2.3 2.3a1 1 0 0 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 1 1 1.42 1.4L3.4 15h.01zM4 7a2 2 0 0 0-2 2 1 1 0 1 1-2 0 4 4 0 0 1 4-4h12.59l-2.3-2.3a1 1 0 1 1 1.42-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.42-1.4L16.6 7H4z"></path></svg>
</button>

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