<button class="uk-icon bg-hover  ForceDeletingAll action--delete" uk-icon="delete"></button>

<script>
    $(document).on('click', '.ForceDeletingAll', function () {

        var arrResourceId = [];

        $('.key_dataTable_{{ $model->getKeyName() }}:checked').each(function () {
            arrResourceId.push(this.value);
        });

        UIkit.modal.confirm(
            '<h2>حذف رکورد ها</h2>' +
            '<h3>شما دارید این  رکورد ها رو حذف می کنید مطمئن هستید</h3>'
            , {
                labels: {ok: 'حذف', cancel: 'خیر'},
                addClass: 'modal_delete'
            }).then(function () {
            @if (method_exists($request->Model() , 'isForceDeleting'))
            DestroySoftDeleting(arrResourceId);
            @else
            Destroy(arrResourceId);
            @endif


        });

    });

</script>