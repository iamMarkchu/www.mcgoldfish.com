@extends('layouts.page')
@section('main_content')
    <div class="col-md-9 col-sm-12 mark-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="text-center">{{ $article->title }}</h1>
            </div>
            <div class="panel-body mark-markdown-block">
                {!! $article->htmlContent !!}
            </div>
        </div>
    </div>
    <div class="col-md-3 hidden-sm">
        <div class="article-menu affix-top" data-spy="affix" data-offset-top="0" data-offset-bottom="10">
            <div class="panel panel-default">
                <div class="panel-heading">目录</div>
                <div class="panel-body">
                    <ul class="header-list">
                        @foreach($headers as $index => $header)
                            <li>
                                <a href="#{{ $index }}">{{ $header['title'] }}</a>
                                @if(isset($header['h3']))
                                    <ol class="sub-header-list">
                                        @foreach($header['h3'] as $subIndex => $subHeader)
                                            <li><a href="#{{ $subIndex }}">{{ $subHeader }}</a></li>
                                        @endforeach
                                    </ol>
                                @endif
                            </li>
                        @endforeach
                        <li><a href="#header_1">返回顶部</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection