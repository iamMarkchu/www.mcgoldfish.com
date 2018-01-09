@extends('layouts.app')
@section('content')
    <div id="content">
        <div class="container mark-container">
            @include('block.left-fixed-menu')
            @yield('main_content')
        </div>
    </div>
@endsection