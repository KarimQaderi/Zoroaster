@php
    if ($previous  == 0 || $previous == null || $value == 0)
              $increaseOrDecrease = 0;
          else
              $increaseOrDecrease = number_format((float)((( $value  -  $previous ) /  $previous ) * 100), 2, '.', '');

     function creaseLabel($increaseOrDecrease) {
            switch (sign($increaseOrDecrease)) {
                case 1:
                    return 'Increase';
                case 0:
                    return 'Constant';
                case -1:
                    return 'Decrease';
            }
        }

        $increaseOrDecreaseLabel = creaseLabel($increaseOrDecrease);

        $growthPercentage = abs($increaseOrDecrease);



function sign($n) {
    return ($n > 0) - ($n < 0);
}

@endphp

<div class="metrics metrics-{{ $classN }}">
    <div uk-grid>
        <div class="uk-width-1-2 label">{{ $label }}</div>
        <div class="uk-width-1-2 uk-text-left">
            <select>
                @foreach($ranges as $key => $_value)
                    <option @if ($range == $key) selected @endif value="{{ $key }}">{{ $_value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="count">{{ (int)($value) }}</div>
    <div class="previous">

        @if(in_array($increaseOrDecreaseLabel,['Increase','Decrease']))
            <svg class="{{ $increaseOrDecreaseLabel }} uk-icon" width="20" height="12">
                <path d="M2 3a1 1 0 0 0-2 0v8a1 1 0 0 0 1 1h8a1 1 0 0 0 0-2H3.414L9 4.414l3.293 3.293a1 1 0 0 0 1.414 0l6-6A1 1 0 0 0 18.293.293L13 5.586 9.707 2.293a1 1 0 0 0-1.414 0L2 8.586V3z"/>
            </svg>
        @endif

        @if ($increaseOrDecrease != 0)

            <span>
                @if ($growthPercentage !== 0)
                    <span>
                        {{ $growthPercentage }} % &nbsp;{{ ($increaseOrDecreaseLabel == '') }}
                        @switch($increaseOrDecreaseLabel)
                            @case('Increase') افزایش @break
                            @case('Constant') ثابت @break
                            @case('Decrease') کاهش @break
                        @endswitch
                    </span>
                @else
                    <span>
                        بدون افزایش
                    </span>
                @endif
            </span>

        @else

            <span>
                @if ($previous == '0' && $value != '0')
                    <span>
                        بدون داده قبلی
                    </span>
                @endif

                @if ($value == '0' && $previous != '0')
                    <span>
                        بدون اطلاعات جاری
                    </span>
                @endif

                @if ($value == '0' && $previous == '0')
                    <span> بدون اطلاعات</span>
                @endif
            </span>

        @endif


    </div>
</div>
