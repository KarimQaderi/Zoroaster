<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>

    <meta name="_token" content="{{ csrf_token() }}"/>


    <title>Zoroaster</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="Development" content="Partak Group Ltd."/>
    <meta name="Author" content="Hessam Shahpouri"/>
    <link rel="icon" type="image/png" href="favicon.png"/>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico"/>


    {{--<link rel="stylesheet" type="text/css" href="{{ mix('css/back_2.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/back.css') }}"/>--}}


    {{--<script type="application/javascript" src="/js/jquery.js"></script>--}}
    {{--<script type="application/javascript" src="/js/uikit.js"></script>--}}
    {{--<script type="application/javascript" src="/js/uikit-icons.js"></script>--}}


    <script type="application/javascript" src="{{ asset('js/ZoroasterJs.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ZoroasterCss.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/back.css') }}"/>



    <script>

        jQuery(function () {


            function sidebarToggle(toogle) {
                console.log(toogle);
                var sidebar = jQuery("#sidebar"), padder = $(".tm-main");
                if (toogle) {
                    jQuery(".notyf").removeAttr("style");
                    // jQuery("#sidebar_toggle").addClass("is-active");
                    // jQuery("#overlay").addClass("open");
                    sidebar.animate({'margin-right': 0, opacity: 1, display: 'block'}, "slow");
                    padder.animate({'margin-right': 280, display: 'block'}, "slow");


                } else {
                    jQuery(".notyf").css({"width": "90%", "margin": "0 auto", "display": "block", "right": 0, "left": 0});
                    sidebar.css({"display": "block", "x": "0px"});
                    jQuery("#sidebar_toggle").removeClass("is-active");
                    jQuery("#overlay").removeClass("open");
                    sidebar.animate({'margin-right': -300, opacity: 0, display: 'none'}, "slow");
                    padder.animate({'margin-right': 0, display: 'none'}, "slow");
                }
            }


            jQuery("#sidebar_toggle").click(function () {
                var sidebar = $("#sidebar"), padder = jQuery(".tm-main");
                sidebarToggle(sidebar.css('margin-right') == "-300px");
            });


        });
    </script>
</head>
<body>
<div class="uk-offcanvas-content" style="min-height: 100%;">
    <div id='overlay' class="uk-hidden@m"></div>

    <div id="sidebar" class="tm-sidebar-right uk-background-default mCustomScrollbar" data-mcs-theme="minimal-dark">



        {!! Zoroaster::Sidebar() !!}

    </div>
    <div class="tm-main">
        <div class="tm-title uk-section-small uk-section-default header">
            <div class="uk-container uk-container-expand">
                <a id="sidebar_toggle" href="#"><i uk-icon="chevron-left"></i> </a>
                <h2 class="uk-display-inline-block">@yield('title')</h2>
            </div>
        </div>
        <div class="tm-content uk-padding-remove-vertical uk-section-muted uk-height-viewport">
            <div class="tm-container uk-container uk-container-expand uk-padding-small">

                @include('Zoroaster::partials.massage')

                @yield('content')
            </div>
        </div>
    </div>
</div>


</body>
</html>
