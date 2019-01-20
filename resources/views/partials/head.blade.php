<meta name="_token" content="{{ csrf_token() }}"/>


<title>Zoroaster</title>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<meta name="Author" content="Karim Qaderi"/>
<link rel="icon" href="{{ Zoroaster::asset('img/logo.png') }}">

<script type="application/javascript" src="{{ Zoroaster::asset('js/ZoroasterJs.js') }}"></script>
<script type="application/javascript" src="{{ Zoroaster::asset('js/resources.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ Zoroaster::asset('css/ZoroasterCss.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ Zoroaster::asset('css/back.css') }}"/>


@foreach(Zoroaster::scripts() as $script)
    <script type="application/javascript" src="{{ $script }}"></script>
@endforeach

@foreach(Zoroaster::styles() as $style)
    <link rel="stylesheet" type="text/css" href="{{ $style }}"/>
@endforeach

<script>
    var Zoroaster_jsRoute = JSON.parse('@json(Zoroaster::jsRoute())');
</script>

