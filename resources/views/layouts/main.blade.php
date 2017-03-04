<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" value="{{csrf_token()}}">

    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">

    <title>@yield('title')</title>
</head>
<body>
    <div id="vue-root">
        @include('shared.header')

        <div class="container" >
            <div class="main">
                <div class="row">
                    <div class="twelve columns">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
