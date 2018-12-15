<div class="metrics">
    <div uk-grid>
        <div class="uk-width-1-2 label">{{ $label }}</div>
        <div class="uk-width-1-2 uk-text-left">( تعداد : {{ array_sum($value) }} )</div>
    </div>

    <div style="margin-top: 0" uk-grid>
        <div class="uk-width-1-2">
            <div class="list-chart">
                <div class="baron__scroller">
                    <div class="list-chart-{{$classN}}"></div>
                    <div class="baron__track">
                        <div class="baron__bar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2 uk-text-left">
            <div class="ct-chart ct-chart-{{$classN}}" style="display: inline-block;width: 90px; height: 90px; margin-top: 10px;"></div>
        </div>
    </div>

</div>


<script>


    $chart_{{$classN}} = new Chartist.Pie('.ct-chart-{{$classN}}', {
        series: [
                @foreach($value as $key => $_value)
            {
                meta: '{{ $key }}', value: '{{ $_value }}'
            },
            @endforeach
        ]
    }, {
        donut: true,
        donutWidth: 10,
        donutSolid: true,
        startAngle: 270,
        showLabel: false,
    });

    $(document).ready(function () {
        $html = $($chart_{{$classN}}['container']);

        $html.children('svg').children('g').each(function () {
            $h = $('.list-chart-{{$classN}}');
            $path = $(this).find('path');
            $h.append(`<div class="${$(this).attr('class')}"><span>${$path.attr('ct:meta')} ( ${$path.attr('ct:value')}  - ${($path.attr('ct:value') * 100 / '{{ array_sum($value) }}').toFixed(2)}%)</span></div>`);
        });


        baron({
            root: '.list-chart',
            scroller: '.baron__scroller',
            bar: '.baron__bar',
            scrollingCls: '_scrolling',
            draggingCls: '_dragging'
        }).fix({
            elements: '.header__title',
            outside: 'header__title_state_fixed',
            before: 'header__title_position_top',
            after: 'header__title_position_bottom',
            clickable: true
        }).controls({
            // Element to be used as interactive track. Note: it could be different from 'track' param of baron.
            track: '.baron__track',
            forward: '.baron__down',
            backward: '.baron__up'
        });
    });

</script>



