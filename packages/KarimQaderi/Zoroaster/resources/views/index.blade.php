@extends('Zoroaster::layout')
@section('content')

    <h1 class="resourceName">داشبورد</h1>

    <div>
        {!! $widgets !!}
    </div>

    <div class="uk-clearfix"></div>

    <div class="uk-child-width-1-1@s uk-grid-small" uk-grid="">

        <!-- RIGHT: USER INFO -->

        <div class="uk-width-1-3@m">

            <div class="uk-child-width-1-1 uk-grid-small" uk-grid="">

                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header tm-card-header" style="padding: 33px 16px;">
                            <div class="uk-grid-small uk-flex-middle" uk-grid>
                                <div class="uk-width-auto">
                                    <img class="uk-border-circle" style="width:64px; height:64px;" src="http://adsl.tci.ir/panel/assets/images/icon/man.svg" alt="فرتور نمایه" title="3280321"/>
                                </div>
                                <div class="uk-width-expand">
                                    <p class="uk-text-meta uk-margin-remove"><span>{{ auth()->user()->email }}</span></p>
                                    <h4 class="uk-card-title uk-margin-remove-bottom" style="font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ auth()->user()->name }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="tm-card-body">
                            <ul class="uk-list uk-list-divider uk-margin-remove-bottom">
                                <li><i class="uk-margin-small-left fa fa-dot-circle-o" aria-hidden="true"></i>تعداد کاربرا :&ensp; <b>آذربایجان غربی</b></li>
                                <li><i class="uk-margin-small-left fa fa-dot-circle-o" aria-hidden="true"></i>تعداد کاربرای ثبت نشده ایمیل :&ensp; <b>سردشت</b></li>
                                <li><i class="uk-margin-small-left fa fa-dot-circle-o" aria-hidden="true"></i>تاریخ ثبت نام :&ensp; <b>پنج شنبه ۲ آذر ۱۳۹۶ </b></li>
                                <li><i class="uk-margin-small-left fa fa-dot-circle-o" aria-hidden="true"></i>شیوه اشتراک :&ensp; <b class="uk-text-primary">پیش پرداخت</b></li>
                                <li><i class="uk-margin-small-left fa fa-dot-circle-o" aria-hidden="true"></i>وضعیت احراز هویت :&ensp; <b class="uk-text-success">انجام شده</b></li>
                                <li><i class="uk-margin-small-left fa fa-dot-circle-o" aria-hidden="true"></i>وضعیت اینترنت :&ensp; <b class="uk-text-success">بهره برداری</b></li>
                                <li><i class="uk-margin-small-left fa fa-dot-circle-o" aria-hidden="true"></i>اعتبار مالی پنل :&ensp; <b><span dir="ltr">۰</span> &ensp;ریال</b></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- BOTTOM BOX -->

                <div>
                    <div class="uk-card uk-card-default" style="height: 295px; display: flex; align-items: center; justify-content: center;">
                        <a href="http://speedtest.tci.ir" target="_blank" title="تست سرعت مخابرات ایران" style="border:0px none !important; outline: 0px none !important;">
                            <img src="http://adsl.tci.ir/panel/assets/images/speedtest.png" alt="تست سرعت مخابرات ایران" style="height: 240px; width: auto;"/>
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- LEFT: DATA CARDS -->

        <div class="uk-width-expand@m uk-width-1-1@s uk-child-width-1-1 uk-grid-small" uk-grid="">

            <!-- ACTIVE SERVICE -->

            <div>
                <div class="uk-card uk-card-primary">
                    <div class="tm-card-body">
                        <div class="uk-grid-collapse" uk-grid="">
                            <div class="uk-width-expand uk-padding-remove">


                                <div class="chart uk-margin-right" style="float: left;">
                                    <div class="pie-volume-1 percentage" data-percent="35" data-max="163840">
                                        <div class="percent">
                                            <span dir="ltr">54.5GB</span>
                                            <hr/>
                                            <span dir="ltr">160GB</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart uk-margin-right" style="float: left;" title="پایان: چهار شنبه ۳۰ آبان ۱۳۹۷ " uk-tooltip="pos:right">
                                    <div class="pie-volume-1 percentage" data-percent="20" data-max="30">
                                        <div class="percent">
                                            <span>۶ روز</span>
                                            <hr style="border-top-color: rgba(255,255,255,0.3)"/>
                                            <span>۳۰ روز</span>
                                        </div>
                                    </div>
                                </div>

                                <span class="uk-border-bottom">سرویس فعال شما</span>
                                <h5 style="color: #FFFFFF; text-shadow: 1px 1px 0px #000000;">سرویس یک ماهه پیش پرداخت 2Mbps مصرف منصفانه 160 گیگ</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIMED TRAFFIC -->

            <div>
                <div class="uk-card uk-card-sucsess">
                    <div class="tm-card-body">
                        <div class="uk-grid-collapse" uk-grid="">
                            <div class="uk-width-expand uk-padding-remove">

                                <div class="chart uk-margin-right" style="float: left;">
                                    <div class="pie-volume-2 percentage" data-percent="0" data-max="0">
                                        <div class="percent"></div>
                                    </div>
                                </div>
                                <div class="chart uk-margin-right" style="float: left;">
                                    <div class="pie-volume-2 percentage" data-percent="0" data-max="0">
                                        <div class="percent"></div>
                                    </div>
                                </div>

                                <span class="uk-border-bottom">ترافیک زمان‌دار فعال شما</span>
                                <h5 style="color: #FFFFFF; text-shadow: 1px 1px 0px #000000;">بدون ترافیک زمان‌دار فعال</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- DAILY USAGE -->
            <div>
                <div class="uk-card uk-card-default">
                    <div class="tm-card-body">
                        <div class="uk-margin-auto">
                            <canvas id="usage-chart" style="width: 100%; height: 267px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom-box">
                <div class="uk-child-width-1-2@s uk-child-width-1-1 uk-grid-small" uk-grid="">

                    <!-- RESERVED SERVICE -->

                    <div>
                        <div class="uk-card uk-card-secondary">
                            <div class="tm-card-body">
                                <div class="uk-grid-collapse" uk-grid="">
                                    <div class="uk-width-expand">
                                        <span class="uk-margin-remove">سرویس رزرو شما</span>
                                        <h3 class="uk-margin-remove">160 گیگابایتی یک ماهه</h3>
                                    </div>
                                    <div class="uk-width-auto uk-text-left">
                                        <button type="button" onclick="location.href='http://adsl.tci.ir/panel/buy-service';" style="line-height: 20px; width: 56px; height: 56px;"
                                                class="uk-button uk-button-primary uk-padding-remove">فعال سازی</a>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-footer tm-card-footer" title="سرویس یک ماهه پیش پرداخت 2Mbps مصرف منصفانه 160 گیگ" uk-tooltip="delay:500">سرویس یک ماهه پیش پرداخت 2Mbps مصرف
                                منصفانه 160 گیگ
                            </div>
                        </div>
                    </div>

                    <!-- RESERVED CREDIT -->

                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="tm-card-body">
                                <div class="uk-grid-collapse" uk-grid="">
                                    <div class="uk-width-expand">
                                        <span class="uk-margin-remove">ترافیک رزرو شما</span>
                                        <h3 class="uk-margin-remove">0.00 &nbsp;گیگابایت</h3>
                                    </div>
                                    <div class="uk-width-auto uk-text-left">
                                        <i class="fa fa-exchange fa-4x" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-footer tm-card-footer">
                                <a href="http://adsl.tci.ir/panel/buy-traffic">خرید ترافیک اضافه</a>
                            </div>
                        </div>
                    </div>

                    <!-- STATIC IP -->

                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="tm-card-body">
                                <div class="uk-grid-collapse" uk-grid="">
                                    <div class="uk-width-expand">
                                        <span class="uk-margin-remove">IP Static شما</span>
                                        <h3 class="uk-margin-remove">بدون IP Static</h3>
                                    </div>
                                    <div class="uk-width-auto uk-text-left">
                                        <i class="fa fa-server fa-4x" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-footer tm-card-footer">
                                <span>تاریخ انقضا:</span> &nbsp; <b>&mdash;</b>
                            </div>
                        </div>
                    </div>

                    <!-- ROUTE IP -->

                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="tm-card-body">
                                <div class="uk-grid-collapse" uk-grid="">
                                    <div class="uk-width-expand">
                                        <span class="uk-margin-remove">IP Route شما</span>
                                        <h3 class="uk-margin-remove">بدون IP Route</h3>
                                    </div>
                                    <div class="uk-width-auto uk-text-left">
                                        <i class="fa fa-compass fa-4x" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-footer tm-card-footer">
                                <span>تاریخ انقضا:</span> &nbsp; <b>&mdash;</b>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <div class="uk-section-default uk-section-xsmall footer">
        <div class="uk-container uk-container-expand uk-text-center uk-position-relative">
            <div class="rb-copyright">
                <div class="uk-child-width-1-2@m uk-flex-middle uk-grid">
                    <div class="uk-first-column">
                        <div class="uk-text-right@m uk-text-center">
                            <p class="uk-margin-remove">کلیه حقوق این سامانه متعلق به شرکت مخابرات ایران می باشد.</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="uk-text-left@m uk-text-center">
                            <!-- <p class="uk-margin-remove" style="direction: ltr;">Powered By <span class="uk-badge" >Partak Group</span></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop