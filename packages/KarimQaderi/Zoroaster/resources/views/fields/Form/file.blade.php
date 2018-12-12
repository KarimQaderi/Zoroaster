<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <div class="js-upload-{{ $field->name }} uk-placeholder uk-text-center">
        <span uk-icon="icon: cloud-upload"></span>
        <span class="uk-text-middle">برای اپلود فایل مورد نظر خود را بکشید به اینجا</span>
        <div uk-form-custom>
            <input type="file" multiple>
            <span class="uk-link">یک فایل انتخاب کنید</span>
        </div>
    </div>
</label>
<progress id="js-progressbar-{{ $field->name }}" class="uk-progress" value="0" max="100" hidden></progress>
<div class="imgUpload" id="imgUpload_{{ $field->name }}" uk-sortable="handle: .uk-sortable-handle">
    <template>
        <div class="imgUpload_img">
            <div class="top">
                <span uk-icon="delete" class="delete"></span>
                <a href="${RealPath}" uk-icon="view"></a>
                <span class="uk-sortable-handle" uk-icon="move"></span>
            </div>
            <img src="${RealPath}">
            <input id="url" type="hidden" name="{{ $field->name }}[${number}][url]" value="${url}">
            <input id="resize" type="hidden" name="{{ $field->name }}[${number}][resize]" value="${resize}">
        </div>
    </template>

    @isset($data->{$field->name})
        @if (is_string($data->{$field->name}) || ($data->{$field->name})=='')

            @if (!is_null($data->{$field->name}))
                <div class="imgUpload_img">
                    <div class="top">
                        <span uk-icon="delete" class="delete"></span>
                        <a href="{{ Storage::disk($field->disk)->url($data->{$field->name}) }}" uk-icon="download-2"></a>
                        <span class="uk-sortable-handle" uk-icon="move"></span>
                    </div>
                    <div class="baseName">{{ array_last(explode('/',$val)) }}</div>
                    <input id="url" type="hidden" name="{{ $field->name }}[${number}][url]" value="{{ $data->{$field->name} }}">
                </div>
            @endif

        @else

            @foreach(($data->{$field->name}) as $val)
                @php($time=time() . random_int(100 , 1000))
                <div class="imgUpload_img">
                    <div class="top">
                        <span uk-icon="delete" class="delete"></span>
                        <a href="{{ Storage::disk($field->disk)->url($val) }}" uk-icon="download-2"></a>
                        <span class="uk-sortable-handle" uk-icon="move"></span>
                    </div>
                    <div class="baseName">{{ array_last(explode('/',$val)) }}</div>
                    <input id="url" type="hidden" name="{{ $field->name }}[{{ $time }}][url]" value="{{ $val }}">
                </div>

            @endforeach

        @endif
    @endisset


</div>


<script>

    function renderHtml(templateSelector) {
        var html = $(templateSelector).html();
        $(templateSelector).remove();
        return html;
    }

    function render(_append, mainTepmlate, items) {

        var i = 0, j = 0, Tepmlate = null;
        // $.each(items, function (key, value) {
        Tepmlate = mainTepmlate;
        $.each(items, function (_key, _value) {
            Tepmlate = Tepmlate.replace(new RegExp('[$]{' + _key + '}', 'g'), _value);
        });
        // Tepmlate += Tepmlate;
        // });

        $(_append).append(Tepmlate);
    }

    var TepmlateImgUpload_{{ $field->name }}  = renderHtml('#imgUpload_{{ $field->name }} template');



</script>

<script>

    $(document).on('click', '#imgUpload_{{ $field->name }} .imgUpload_img .delete', function (e) {
        var imgUpload_img = $(this).closest('.imgUpload_img');
        console.log(imgUpload_img.find('#resize').val());
        UIkit.modal.confirm(
            '<h2>حذف عکس</h2>' +
            '<h3>شما دارید این  عکس رو حذف می کنید مطمئن هستید</h3>'
            , {
                labels: {ok: 'حذف', cancel: 'خیر'},
                addClass: 'modal_delete'
            }).then(function () {

            $.ajax({
                type: 'POST',
                url: '{{ route('Zoroaster.Ajax.field') }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resource: '{{ array_last(explode('\\',$newResource->model)) }}',
                    field: '{{ $field->name }}',
                    controller: 'ResourceUploadDelete',
                    url: imgUpload_img.find('#url').val(),
                },
                success: function (data) {
                    console.log(data);
                    imgUpload_img.remove();

                },
                error: function (data) {

                    var errors = data.responseJSON;
                    console.log(errors.errors);
                }
            });

        });
    });

    var bar_{{ $field->name }} = document.getElementById('js-progressbar-{{ $field->name }}');

    UIkit.upload('.js-upload-{{ $field->name }}', {

        url: '{{ route('Zoroaster.Ajax.field') }}',
        multiple: true,
        name: 'file',
        params: {
            _token: '{{ csrf_token() }}',
            resource: '{{ array_last(explode('\\',$newResource->model)) }}',
            controller: 'ResourceUpload',
            field: '{{ $field->name }}',
        },

        beforeSend: function () {
            // console.log('beforeSend', arguments);

        },
        beforeAll: function () {
            console.log('beforeAll', arguments);

            if (!(($('#imgUpload_{{ $field->name }} > *').length + arguments[1].length) <= '{{ $field->count }}')) {
                alert('تعداد فایل ها زیاد هست حداکثر فایل ها ({{ $field->count }}) عدد');
                abort();
            }
        },
        load: function () {
            // console.log('load', arguments);

        },
        error: function () {
            // console.log('error', arguments);
        },
        complete: function () {
            // console.log('complete', arguments);
        },

        loadStart: function (e) {
            // console.log('loadStart', arguments);

            bar_{{ $field->name }}.removeAttribute('hidden');
            bar_{{ $field->name }}.max = e.total;
            bar_{{ $field->name }}.value = e.loaded;
        },

        progress: function (e) {
            // console.log('progress', arguments);
            //
            bar_{{ $field->name }}.max = e.total;
            bar_{{ $field->name }}.value = e.loaded;
        },

        loadEnd: function (e) {
            // console.log('loadEnd', arguments);

            render('#imgUpload_{{ $field->name }}', TepmlateImgUpload_{{ $field->name }} , $.parseJSON(e.currentTarget.response));

            bar_{{ $field->name }}.max = e.total;
            bar_{{ $field->name }}.value = e.loaded;
        },

        completeAll: function () {
            // console.log('completeAll', arguments);

            setTimeout(function () {
                bar_{{ $field->name }}.setAttribute('hidden', 'hidden');
            }, 500);


            // alert('Upload Completed');
        }

    });

</script>