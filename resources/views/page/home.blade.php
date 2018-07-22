@extends('layouts.page')
@section('main_content')
<div class="col-md-12 col-sm-12 mark-content">
    @foreach($articles as $article)
        <div class="panel panel-default home-article-block">
            <div class="panel-heading">
                <h3 class="panel-title"><a href="{{ route('article-v2', ['url_name' => $article->url_name ]) }}">{{ ucfirst($article->title) }}</a></h3>
            </div>
            <div class="panel-body">
                {!! $article->preview !!}
            </div>
            <div class="panel-footer">
                <div class="item-box pull-left">
                    @if(count($article->tags) > 0)
                        <span class="glyphicon glyphicon-tags tag-icon" aria-hidden="true"></span>
                        @foreach($article->tags as $tag)
                            <span class="tag-item">{{ ucfirst($tag->tag_name) }}</span>
                        @endforeach
                    @endif
                    <span class="glyphicon glyphicon-user tag-icon" aria-hidden="true"></span>
                    <span class="tag-item">{{ $article->user->name }}</span>
                    <span class="glyphicon glyphicon-time tag-icon" aria-hidden="true"></span>
                    <span class="tag-item">{{ diff_time($article->updated_at) }}</span>
                </div>
                <div class="item-box pull-right">
                    <a href="{{ route('article-v2', ['url_name' => $article->url_name ]) }}" role="button">阅读全文 >></a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    @endforeach
    {{ $articles->links() }}
</div>
@endsection