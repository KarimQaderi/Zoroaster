        @if (is_string($data->{$field->name}) || ($data->{$field->name})=='')

            @if (!is_null($data->{$field->name}))
<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
</label>

<div class="imgUpload" id="imgUpload_{{ $field->name }}"   uk-lightbox>

    @isset($data->{$field->name})
        @if (is_string($data->{$field->name}) || ($data->{$field->name})=='')

            @if (!is_null($data->{$field->name}))
                <div class="imgUpload_img">
                    <div class="top">
                        <a href="{{ Storage::disk($field->disk)->url($data->{$field->name}) }}" uk-icon="view"></a>
                    </div>
                    <img src="{{ Storage::disk($field->disk)->url($data->{$field->name}) }}">
                    <input id="url" type="hidden" name="{{ $field->name }}[${number}][url]" value="{{ $data->{$field->name} }}">
                    <input id="resize" type="hidden" name="{{ $field->name }}[${number}][resize]" value="{{ json_encode($field->resize) }}">
                </div>
            @endif

        @else

            @foreach(($data->{$field->name}) as $val)
                @php($time=time() . random_int(100 , 1000))
                <div class="imgUpload_img">
                    <div class="top">
                        <a href="{{ Storage::disk($field->disk)->url($val['url']) }}" uk-icon="view"></a>
                    </div>
                    <img src="{{ Storage::disk($field->disk)->url($val['url']) }}">
                    <input id="url" type="hidden" name="{{ $field->name }}[{{ $time }}][url]" value="{{ $val['url'] }}">
                    <input id="resize" type="hidden" name="{{ $field->name }}[{{ $time }}][resize]" value="{{ isset($val['resize'])? $val['resize'] : '[]' }}">
                </div>

            @endforeach

        @endif
    @endisset
</div>



