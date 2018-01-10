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
    @if(config('app.env') === 'production')
        <meta name="baidu-site-verification" content="4twX2WjDLk" />
        <script>
            var _hmt = _hmt || [];
            (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?1a190f4c8046de525cccfe1b2ae4f03c";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();
        </script>
    @endif
</head>
<body>
    <div id="app">
        @include('block.nav')
        @yield('content')
        @include('block.footer')
    </div>
    <div class="dialog-block">
        @include('block.message-dialog')
        @include('block.force-login')
    </div>
    @section('page-js')
        <script src="{{ mix('js/app.js') }}"></script>
    @show
</body>
</html>