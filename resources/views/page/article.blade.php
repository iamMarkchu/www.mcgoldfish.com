@extends('layouts.page')
@section('main_content')
<div class="col-md-12 col-sm-12 mark-content">
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
            <h3 class="panel-title" id="comment">评论@if($comments->has(0))({{ $comments->get(0)->count() }})@endif</h3>
        </div>
        <div class="panel-body">
            <form name="commentForm" action="" method="post">
                <div class="form-group">
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea id="comment_content" name="comment_content" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <a href="javascript:;" class="btn btn-success btn-sm pull-right commentSubmit" role="button">评论</a>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
        <div class="panel-body">
            @if($comments->has(0))
                @include('block.comment-list', ['collection' => $comments->get(0)])
            @endif
        </div>
    </div>
</div>
@endsection