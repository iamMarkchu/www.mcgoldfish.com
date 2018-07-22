@extends('layouts.app')
@section('content')
    @if(Route::currentRouteName() == 'index')
        <div id="banner">
            <div class="container banner-container">
                <h1 class="text-center">echo "Hello World";</h1>
                <h2 class="text-center">PHP是世界上最好的语言<small>(正在学习python)</small></h2>
            </div>
        </div>
    @endif
    <div id="content">
        <div class="container mark-container">
            @include('block.left-fixed-menu')
            @yield('main_content')
            @include('block.suspension-panel')
        </div>
    </div>
@endsection