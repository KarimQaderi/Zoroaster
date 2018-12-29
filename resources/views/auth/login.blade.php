<!DOCTYPE html>
<html>

<head>

    <title>{{ config('app.name_2', 'Laravel') }}</title>

    @include('Zoroaster::partials.head')

</head>

<body dir="rtl" class="uk-background-muted uk-height-viewport">



<div id="app">

    <div class="Zoroaster-login" uk-icon="Zoroaster"></div>

    <div class="uk-container uk-margin-large uk-flex uk-flex-center">
        <div class="uk-card  uk-width-1-2@s  login">

            <div class="uk-card-header">
                <h3 class="uk-card-title uk-margin-remove">خوش آمدید</h3>
            </div>

            <form class="uk-form-stacked" method="POST" action="{{ route('Zoroaster.login') }}" >
                {{ csrf_field() }}
                <div class="uk-card-body">
                    <div class="uk-margin">
                        <label class="uk-form-label {{  $errors->has('email') ? ' uk-text-danger' : '' }}">
                           ایمیل
                        </label>
                        <div class="uk-width-1-1 uk-inline">
						<span class="uk-form-icon {{  $errors->has('email') ? ' uk-text-danger' : '' }}" uk-icon="icon: user">
						</span>
                            <input id="email" type="email" class="uk-input {{  $errors->has('email') ? ' uk-form-danger' : '' }}"
                                   name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        @if ( $errors->has('email'))
                            <span class="uk-text-small uk-text-danger">{{  $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label {{  $errors->has('password') ? ' uk-text-danger' : '' }}">
                            رمز
                        </label>
                        <div class="uk-width-1-1 uk-inline">
						<span class="uk-form-icon {{  $errors->has('password') ? ' uk-text-danger' : '' }}"
                              uk-icon="icon: lock">
						</span>
                            <input id="password" type="password" class="uk-input {{  $errors->has('password') ? ' uk-form-danger' : '' }}"
                                   name="password" required>
                        </div>
                        @if ( $errors->has('password'))
                            <span class="uk-text-small uk-text-danger">{{  $errors->first('password') }}</span>
                        @endif
                    </div>

                </div>
                <div class="uk-card-footer uk-clearfix">
                    <button type="submit" class="uk-button uk-button-primary uk-box-shadow-medium">
                        ورود
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


</body>
</html>