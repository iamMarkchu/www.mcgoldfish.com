<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($seo['title'])? $seo['title']: config('seo.title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="/favicon.png">
</head>
<body>
    <div id="app">
        @include('block.nav')
        @yield('content')
        @include('block.footer')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>