<label>
    <button  class="btn uk-button uk-button-primary uk-border-rounded Create-and-add-another-one">ایجاد و اضافه کردن یکی دیگر</button>
    <input type="hidden" name="redirect" value="">
</label>

<script>

    $(document).on('click','Create-and-add-another-one',function () {
        $('[name="redirect"]').val('{{ url()->current() }}');
        $('[type="submit"]').click();
    });

</script>