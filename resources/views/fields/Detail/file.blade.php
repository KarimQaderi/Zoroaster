<label>
    <span class="label">{{ $field->label }}</span>
</label>
<div class="imgUpload" id="imgUpload_{{ $field->name }}">


    @isset($value)
        @if (is_string($value) || ($value)=='')

            @if (!is_null($value))
                <div class="imgUpload_img">
                    <div class="top">
                        <a href="{{ Storage::disk($field->disk)->url($value) }}" uk-icon="download-2"></a>
                    </div>
                    <div class="baseName">{{ array_last(explode('/',$value)) }}</div>
                    <input id="url" type="hidden" name="{{ $field->name }}[${number}][url]" value="{{ $value }}">
                </div>
            @endif

        @else

            @foreach(($value) as $val)
                @php($time=time() . random_int(100 , 1000))
                <div class="imgUpload_img">
                    <div class="top">
                        <a href="{{ Storage::disk($field->disk)->url($value) }}" uk-icon="download-2"></a>
                    </div>
                    <div class="baseName">{{ array_last(explode('/',$value)) }}</div>
                    <input id="url" type="hidden" name="{{ $field->name }}[{{ $time }}][url]" value="{{ $value }}">
                </div>

            @endforeach

        @endif
    @endisset


</div>
