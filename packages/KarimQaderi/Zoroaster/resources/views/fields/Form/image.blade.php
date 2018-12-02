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

    <progress id="js-progressbar-{{ $field->name }}" class="uk-progress" value="0" max="100" hidden></progress>
</label>

<div class="imgUpload" uk-sortable="handle: .uk-sortable-handle" uk-lightbox>
    <template>
        <div class="imgUpload_img">
            <div class="top">
                <span uk-icon="close"></span>
                <a href="${url}" uk-icon="plus-circle"></a>
                <span class="uk-sortable-handle" uk-icon="move"></span>
            </div>
            <img src="${url}">
            <input type="hidden" name="[{{ $field->name }}][url][]" value="${url}">
            <input type="hidden" name="[{{ $field->name }}][name][]" value="${name}">
            <input type="hidden" name="[{{ $field->name }}][size][]" value="${size}">
            <input type="hidden" name="[{{ $field->name }}][resize][]" value="${resize}">
            <div class="thumbnav">
                <a href="http://127.0.0.1:8000/users/2018/11/27-1543340423-lodge_lake_azure_reflection_sky_tranquillity_61165_3840x2160.jpg"><img
                            src="http://127.0.0.1:8000/users/2018/11/27-1543340423-lodge_lake_azure_reflection_sky_tranquillity_61165_3840x2160.jpg"></a>
                <a href="http://127.0.0.1:8000/users/2018/11/27-1543340423-lodge_lake_azure_reflection_sky_tranquillity_61165_3840x2160.jpg"><img
                            src="http://127.0.0.1:8000/users/2018/11/27-1543340423-lodge_lake_azure_reflection_sky_tranquillity_61165_3840x2160.jpg"></a>
                <a href="http://127.0.0.1:8000/users/2018/11/27-1543340423-lodge_lake_azure_reflection_sky_tranquillity_61165_3840x2160.jpg"><img
                            src="http://127.0.0.1:8000/users/2018/11/27-1543340423-lodge_lake_azure_reflection_sky_tranquillity_61165_3840x2160.jpg"></a>
            </div>
        </div>
    </template>
</div>
{{--<input class="uk-input" name="{{ $data->name }}" type="file">--}}
@isset($data->{$field->name} )
    <img src="{{ $data->{$field->name} }}">
@endisset




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

    var TepmlateImgUpload = renderHtml('.imgUpload template');

    var items = [{
        url: '/users/2018/11/24-1543060055-download.jpg',
        name: '24-1543060055-download.jpg',
    }, {
        url: '/users/2018/11/24-1543060055-download.jpg',
        name: '24-1543060055-download.jpg',
    }];

    // render('.imgUpload', TepmlateImgUpload, items);


</script>

<script>

    var bar = document.getElementById('js-progressbar-{{ $field->name }}');

    UIkit.upload('.js-upload-{{ $field->name }}', {

        url: '{{ route('Zoroaster.upload.fields') }}',
        multiple: true,
        params: {
            _token: '{{ csrf_token() }}',
            urlUpload: '{{ $field->urlUpload }}',
            resize: '{{ $field->resize }}'
        },

        beforeSend: function () {
            console.log('beforeSend', arguments);
            console.log ($('.imgUpload>*').length + arguments.length) +'<='+ '{{ $field->multiImage }}'));

            if (!(($('.imgUpload>*').length + arguments.length) <= '{{ $field->multiImage }}')) {
                alert('تعداد فایل ها زیاد هست حداکثر فایل ها ({{ $field->multiImage }}) عدد');
                abort(0);
            }

        },
        beforeAll: function () {
            // console.log('beforeAll', arguments);
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

            bar.removeAttribute('hidden');
            bar.max = e.total;
            bar.value = e.loaded;
        },

        progress: function (e) {
            // console.log('progress', arguments);
            //
            bar.max = e.total;
            bar.value = e.loaded;
        },

        loadEnd: function (e) {
            // console.log('loadEnd', arguments);

            render('.imgUpload', TepmlateImgUpload, $.parseJSON(e.currentTarget.response));

            bar.max = e.total;
            bar.value = e.loaded;
        },

        completeAll: function () {
            // console.log('completeAll', arguments);

            setTimeout(function () {
                bar.setAttribute('hidden', 'hidden');
            }, 500);


            alert('Upload Completed');
        }

    });

</script>