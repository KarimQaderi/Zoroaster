<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="Development" content="Partak Group Ltd."/>
    <meta name="Author" content="Hessam Shahpouri"/>
    <link rel="icon" type="image/png" href="favicon.png"/>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico"/>


    <link rel="stylesheet" type="text/css" href="{{ mix('css/back_2.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/back.css') }}"/>


    <script type="application/javascript" src="/js/jquery.js"></script>
    <script type="application/javascript" src="/js/uikit.js"></script>
    <script type="application/javascript" src="/js/uikit-icons.js"></script>


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

        <!-- Menu Header -->

        <div class="tm-user uk-text-center uk-light">
            <div class="tm-date">
                <span class="tm-date-jalali">چهار شنبه، ۹ آبان ۱۳۹۷</span>
                <span class="tm-date-gregorian">Wednesday, 31 October 2018</span>
            </div>
        </div>

        <!-- Menu Items -->

        <ul id="side-menu" class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <li class="">
                <a href="default.htm"><i class="uk-margin-small-left fa fa-tachometer"></i> داشبورد</a>
            </li>
            <li class="uk-nav-divider">
            </li>
            <li class="uk-parent">
                <a href="javascript:void(0)"><i class="uk-margin-small-left fa fa-shopping-cart"></i> مرکز خرید</a>
                <ul class="uk-nav-sub">
                    <li class="">
                        <a href="buy-service"><i class="uk-margin-small-left fa fa-shopping-basket"></i> خرید سرویس</a>
                    </li>
                    <li class="">
                        <a href="buy-traffic"><i class="uk-margin-small-left fa fa-shopping-basket"></i> خرید ترافیک اضافه</a>
                    </li>
                    <li class="">
                        <a href="buy-timed-traffic"><i class="uk-margin-small-left fa fa-shopping-basket"></i> خرید ترافیک زمان‌دار</a>
                    </li>
                    <li class="">
                        <a href="change-service"><i class="uk-margin-small-left fa fa-refresh"></i> تغییر سرویس</a>
                    </li>
                    <li class="">
                        <a href="renew-ip"><i class="uk-margin-small-left fa fa-globe"></i> تمدید IP Static</a>
                    </li>
                    <li class="">
                        <a href="failed-recharges"><i class="uk-margin-small-left fa fa-check-square"></i> انجام شارژهای ناموفق</a>
                    </li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="javascript:void(0)"><i class="uk-margin-small-left fa fa-plus-circle"></i> خدمات ارزش افزوده</a>
                <ul class="uk-nav-sub">
                    <li class="">
                        <a href="order-aio"><i class="uk-margin-small-left fa fa-tv"></i> تلویزیون اینترنتی AIO</a>
                    </li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="javascript:void(0)"><i class="uk-margin-small-left fa fa-wrench"></i> عملیات‌های حساب</a>
                <ul class="uk-nav-sub">
                    <li class="">
                        <a href="usage-limit"><i class="uk-margin-small-left fa fa-compress"></i> محدود سازی</a>
                    </li>
                    <li class="">
                        <a href="free-charge"><i class="uk-margin-small-left fa fa-gift"></i> شارژ رایگان</a>
                    </li>
                    <li class="">
                        <a href="charge-card"><i class="uk-margin-small-left fa fa-barcode"></i> کارت شارژ</a>
                    </li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="javascript:void(0)"><i class="uk-margin-small-left fa fa-address-card-o"></i> حساب کاربری</a>
                <ul class="uk-nav-sub">
                    <li class="">
                        <a href="profile"><i class="uk-margin-small-left fa fa-id-card-o"></i> مشخصات فردی</a>
                    </li>
                    <li class="">
                        <a href="upload"><i class="uk-margin-small-left fa fa-upload"></i> بارگذاری مدارک</a>
                    </li>
                    <li class="">
                        <a href="change-web-pass"><i class="uk-margin-small-left fa fa-key"></i> تغییر گذرواژه پنل</a>
                    </li>
                    <li class="">
                        <a href="change-net-pass"><i class="uk-margin-small-left fa fa-key"></i> تغییر گذرواژه اینترنت</a>
                    </li>
                    <li class="">
                        <a href="usage-details"><i class="uk-margin-small-left fa fa-area-chart"></i> ریز مصرف اینترنت</a>
                    </li>
                    <li class="">
                        <a href="print-contract"><i class="uk-margin-small-left fa fa-print"></i> چاپ قرارداد</a>
                    </li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="javascript:void(0)"><i class="uk-margin-small-left fa fa-university"></i> بانکداری مجازی</a>
                <ul class="uk-nav-sub">
                    <li class="">
                        <a href="ewallet-recharge"><i class="uk-margin-small-left fa fa-credit-card"></i> افزایش اعتبار مالی</a>
                    </li>
                    <li class="">
                        <a href="transactions"><i class="uk-margin-small-left fa fa-file-text-o"></i> تراکنش‌های مالی</a>
                    </li>
                    <li class="">
                        <a href="print-order"><i class="uk-margin-small-left fa fa-print"></i> صدور فاکتور</a>
                    </li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="javascript:void(0)"><i class="uk-margin-small-left fa fa-life-ring"></i> پشتیبانی</a>
                <ul class="uk-nav-sub">
                    <li class="">
                        <a href="tickets"><i class="uk-margin-small-left fa fa-ticket"></i> درخواست‌های پشتیبانی</a>
                    </li>
                    <li class="">
                        <a href="gathering"><i class="uk-margin-small-left fa fa-user-times"></i> درخواست جمع آوری</a>
                    </li>
                    <li class="">
                        <a href="polls"><i class="uk-margin-small-left fa fa-check-square-o"></i> نظرسنجی سامانه</a>
                    </li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="javascript:void(0)"><i class="uk-margin-small-left fa fa-id-card"></i> سابقه‌های کاربری</a>
                <ul class="uk-nav-sub">
                    <li class="">
                        <a href="history-line"><i class="uk-margin-small-left fa fa-lightbulb-o"></i> تغییرات وضعیت اینترنت</a>
                    </li>
                    <li class="">
                        <a href="history-service"><i class="uk-margin-small-left fa fa-history"></i> سرویس‌های خریداری شده</a>
                    </li>
                    <li class="">
                        <a href="history-recharge"><i class="uk-margin-small-left fa fa-calendar"></i> شارژهای ماهیانه</a>
                    </li>
                    <li class="">
                        <a href="history-billing"><i class="uk-margin-small-left fa fa-barcode"></i> قبض‌های اینترنت</a>
                    </li>
                    <li class="">
                        <a href="history-sms"><i class="uk-margin-small-left fa fa-envelope-o"></i> پیامک‌های دریافتی</a>
                    </li>
                </ul>
            </li>
            <li class="uk-hidden@l uk-hidden@xl">
                <a href="logout"><i class="uk-margin-small-left fa fa-sign-out"></i> خروج</a>
            </li>
        </ul>


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

                    @include('back.inc.massage')

                @yield('content')
            </div>
        </div>
    </div>
</div>


</body>
</html>
