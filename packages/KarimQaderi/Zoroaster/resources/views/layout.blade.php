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
            <nav uk-navbar>
                <div class="uk-navbar-right">
                    <a id="sidebar_toggle" href="#"><i uk-icon="chevron-left"></i> </a>
                    <div class="uk-display-inline-block GlobalSearch">
                        <form class="uk-search">
                            <span class="uk-search-icon-flip" uk-search-icon></span>
                            <input class="uk-search-input" type="search" placeholder="جستجو...">
                        </form>
                        <div class="data" data-hidden="0">
                            <div class="NoItem">متن خود را جستجو کنید</div>
                        </div>
                    </div>

                    {!! Zoroaster::Navbar('right') !!}

                </div>
                <div class="uk-navbar-center">{!! Zoroaster::Navbar('center') !!}</div>
                <div class="uk-navbar-left">
                   {!! Zoroaster::Navbar('left') !!}
                </div>
            </nav>
        </div>

        <div class="tm-content uk-padding-remove-vertical uk-section-muted uk-height-viewport">
            <div class="tm-container uk-container uk-container-expand uk-padding-small">

                <div class="card">
                    @include('Zoroaster::partials.massage')

                    @yield('content')


                    {{--footer--}}
                    <div class="footer">
                        <a href="https://github.com/KarimQaderi/Zoroaster">Zoroaster</a>
                        © {{ now()->year }} ,
                        ساخته شده توسط : کریم قادری

                    </div>
                    {{--end footer--}}

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


    </div>
</div>


<script>
    $(document).on('click', 'div,span', function () {
        $('.GlobalSearch .data').attr('data-hidden', 0);
    });

    $(document).on('click', '.GlobalSearch div,.GlobalSearch span', function () {
        $('.GlobalSearch .data').attr('data-hidden', 1);
    });

    $(document).on('paste keyup', '.GlobalSearch input', function () {
        $('.GlobalSearch .data').attr('data-hidden', 1);
        $('.GlobalSearch .data').html("<span uk-icon=\"load\"></span>");
        $.ajax({
            type: 'GET',
            url: '{{ route('Zoroaster.globalSearch') }}',
            data: {
                search: $('.GlobalSearch input').val()
            },
            success: function (data) {
                $('.GlobalSearch .data').html(data);
            }
        });
    });
</script>

</body>
</html>
