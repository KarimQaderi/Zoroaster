<div class="btn uk-button uk-button-primary uk-border-rounded CreateAndAddAnotherOne">ایجاد و اضافه کردن یکی دیگر</div>
    <input type="hidden" name="redirect" value="">

<script>
        $(document).on('click','.CreateAndAddAnotherOne',function () {
            console.log('sss');
            $('[name="redirect"]').val('{{ url()->current() }}');
            $('[type="submit"]').click();
        });

</script>