<ul class="uk-navbar-nav user">
    <li>
        <a href="#">

            <span class="name"><span uk-icon="cheveron-down"></span>{{ auth()->user()->name }}</span>
            <img class="uk-border-pill" src="https://secure.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?size=512" width="32" height="32"></a>
        <div class="uk-navbar-dropdown" uk-dropdown="mode: click;offset:20">
            <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a href="{{ route('Zoroaster.logout') }}" uk-icon="sign-out">خروج</a></li>
            </ul>
        </div>
    </li>
</ul>