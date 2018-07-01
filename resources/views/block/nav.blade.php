<nav class="navbar navbar-default navbar-static-top blog-navbar">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand mark-brand" href="{{ url('/') }}">
                <img src="/logo.png" alt="">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right mark-navbar-right">
                <!-- Authentication Links -->
                @guest
                <li><a href="{{route('login', ['callback' => url()->current()])}}">登录</a></li>
                <li><a href="{{route('register', ['callback' => url()->current()])}}">注册</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        {{--<li>--}}
                            {{--<a href="{{ route('user-settings') }}">用户设置</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                退出登录
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>