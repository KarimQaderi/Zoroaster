<div class="metrics">
    <div uk-grid>
        <div class="uk-width-1-2 label">{{ $label }}</div>
        <div class="uk-width-1-2 uk-text-left">
            <select>
                @foreach(is_array($ranges)? $ranges : $ranges->trend as $key => $_value)
                    <option @if ($range == $key) selected @endif value="{{ $key }}">{{ $_value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="chart">
        <div class="ct-chart ct-chart-{{$classN}} ct-perfect-fourth"></div>
    </div>
</div>

<script>


    new Chartist.Line('.ct-chart-{{$classN}}', {
        labels: [10, 0, 0, 9, 0, 7, 8, 0, 5, 5, 0, 5, 5, 3, 0, 0, 5, 4],
        series:
            [
                [
                    @foreach($trend as $key => $_value)
                    {meta: '{{ $key }}', value: '{{ $_value }}' },
                    @endforeach
                ]
            ]

    }, {
        lineSmooth: Chartist.Interpolation.none(),
        fullWidth: true,
        showPoint: true,
        showLine: true,
        showArea: true,
        chartPadding: {
            top: 10,
            right: 0,
            bottom: 0,
            left: 0,
        },
        low: 0,
        axisX: {
            showGrid: false,
            showLabel: true,
            offset: 0,
        },
        axisY: {
            showGrid: false,
            showLabel: true,
            offset: 0,
        },

    });
</script>


<script>

    // Tooltips
    var chartDiv = $('.chart')

    var toolTip = $('body').append('<div class="chartist-tooltip"></div>').find('.chartist-tooltip').hide();
    chartDiv.on('mouseenter', '.ct-point', function () {
        var point = $(this),
            value = point.attr('ct:value'),
            seriesName = point.attr('ct:meta');
        toolTip.html(seriesName + '<br>' + value).show();
    });

    chartDiv.on('mouseleave', '.ct-point', function () {
        toolTip.hide();
    });

    chartDiv.on('mousemove', function (event) {
        toolTip.css({
            left: (event.pageX || event.originalEvent.layerX) - toolTip.width() / 2 - 10,
            top: (event.pageY || event.originalEvent.layerY) - toolTip.height() - 40
        });
    });


</script>
