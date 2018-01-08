@extends('layouts.page')
@section('main_content')
    <div class="col-md-9 col-sm-12 mark-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="text-center article-title">{{ $article->title }}</h1>
            </div>
            <div class="panel-body mark-markdown-block">
                {!! $article->htmlContent !!}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title pull-left" id="comment">评论@if($comments->has(0))({{ $comments->get(0)->count() }})@endif</h3>
                <a class="btn btn-primary btn-xs pull-right" data-toggle="collapse" href="#showCommentBlock" aria-expanded="true" aria-controls="collapseOne">评论</a>
                <div class="clearfix"></div>
            </div>
            <div id="showCommentBlock" class="panel-collapse collapse">
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <textarea id="comment_content" name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <a href="javascript:;" class="btn btn-success btn-sm pull-right commentSubmit" role="button">提交</a>
                            <a href="javascript:;" class="btn btn-sm pull-right commentCancel" role="button">取消</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel-body">
                @if($comments->has(0))
                    @include('block.comment-list', ['collection' => $comments->get(0)])
                @endif
                <div class="modal fade loginDialog" tabindex="-1" role="dialog" aria-labelledby="loginDialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">登录之后才能评论</h4>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('login', [ 'callback' => url()->current(), 'from' => 'comment']) }}" class="btn btn-success">登录</a>
                                <a href="{{ route('register', [ 'callback' => url()->current(),'form' => 'comment']) }}" class="btn btn-primary">注册</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 hidden-md mark-container">
        <div class="article-menu">
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
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection