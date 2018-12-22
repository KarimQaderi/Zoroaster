<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
</label>
<div class="imgUpload" id="imgUpload_{{ $field->name }}">


    @isset($data->{$field->name})
        @if (is_string($data->{$field->name}) || ($data->{$field->name})=='')

            @if (!is_null($data->{$field->name}))
                <div class="imgUpload_img">
                    <div class="top">
                        <a href="{{ Storage::disk($field->disk)->url($data->{$field->name}) }}" uk-icon="download-2"></a>
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
                        <a href="{{ Storage::disk($field->disk)->url($val) }}" uk-icon="download-2"></a>
                    </div>
                    <div class="baseName">{{ array_last(explode('/',$val)) }}</div>
                    <input id="url" type="hidden" name="{{ $field->name }}[{{ $time }}][url]" value="{{ $val }}">
                </div>

            @endforeach

        @endif
    @endisset


</div>
