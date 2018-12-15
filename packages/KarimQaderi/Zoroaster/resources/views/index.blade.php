@extends('Zoroaster::layout')
@section('content')

    <h1 class="resourceName">داشبورد</h1>

    <div>
        {!! Zoroaster::Widgets() !!}
    </div>

    <div class="uk-clearfix"></div>






    <script>

        $(document).on('change','.metrics select',function () {

            $this = $(this).closest('.metrics-body');
            metrics($this.attr('data-class'),$(this).val())
        });


        function metrics(metric,range=null) {

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



@stop