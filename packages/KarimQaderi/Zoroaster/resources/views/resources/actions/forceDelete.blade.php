    <button uk-tooltip="title: حذف کامل; pos: bottom" class="uk-icon bg-hover  MianForceDeletingAll action--delete" uk-icon="force-delete"></button>


<script>
    $(document).on('click', '.MianForceDeletingAll', function () {

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
            Destroy(arrResourceId);
        });

    });

</script>