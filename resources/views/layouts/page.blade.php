@extends('layouts.app')
@section('content')
    <div id="content">
        <div class="container">
            <div class="col-md-9">
                @yield('main_content')
            </div>
            <div class="col-md-3">
                {{--侧边栏--}}
                <div class="panel panel-default">
                    <div class="panel-heading">热门标签</div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection