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
        // location.hash = "parameter1=123&parameter2=abc";

        // ChangeUrl('', 'http://127.0.0.1:8000/Zoroaster?sor=dddddddddddddddd');
        // setParameters([
        //     ['resource', resource],
        // ]);
        // console.log(getUrlVars());

        function index_resources(resource) {

            if (resource === null)
                $this = $(this).closest('resource-ajax');
            else
                $this = $('[data-resource="' + resource + '"]');
            $($this).html("<span uk-icon=\"load\"></span>");

            setParameters([
                ['resource', resource],
            ]);


            ajaxGET('{{ route('Zoroaster.resource-ajax.index') }}',function (data) {
                $this.html(data);

            },function (data) {

                var errors = data.responseJSON;

            });


        }

        function processAjaxData(response, urlPath) {
            document.getElementById("content").innerHTML = response.html;
            document.title = response.pageTitle;
            window.history.pushState({"html": response.html, "pageTitle": response.pageTitle}, "", urlPath);
        }

    </script>

@stop