@extends('Zoroaster::layout')
@section('content')

    <h1 class="resourceName">داشبورد</h1>

    <div class="Widgets">
        {!! Zoroaster::Widgets() !!}
    </div>

    <div class="uk-clearfix"></div>






    <script>

        $(document).on('change', '.metrics select', function () {

            $this = $(this).closest('.metrics-body');
            metrics($this.attr('data-class'), $(this).val())
        });


        function metrics(metric, range = null) {

            $('[data-class="' + metric + '"]').html("<span uk-icon=\"load\"></span>");
            $.ajax({
                type: 'GET',
                url: '{{ route('Zoroaster.metrics') }}',
                data: {
                    class: metric,
                    range: range,
                },
                success: function (data) {
                    $('[data-class="' + data.class + '"]').html(data.html);
                },
                error: function (data) {

                    var errors = data.responseJSON;
                    console.log(errors.errors);

                }
            });
        }
    </script>


    {{--index_resources--}}
    <script>


        function index_resources(resource) {

            if (resource === null)
                $this = $(this).closest('resource-ajax');
            else
                $this = $('[data-resource="' + resource + '"]');


            $($this).html("<span uk-icon=\"load\"></span>");

            $.ajax({
                type: 'GET',
                url: '{{ route('Zoroaster.resource-ajax.index') }}',
                data: {
                    resource: (resource === null) ? $this.attr('data-resource') : resource,
                },
                success: function (data) {
                    $this.html(data);

                },
                error: function (data) {

                    var errors = data.responseJSON;
                    console.log(errors.errors);
                }
            });
        }

    </script>

@stop