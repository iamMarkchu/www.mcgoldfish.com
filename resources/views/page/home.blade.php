@extends('layouts.page')
@section('main_content')
<div class="col-md-9 col-sm-12 mark-content">
    <div class="panel panel-default">
        <div class="panel-heading recommand-heading">
            <h3 class="panel-title">推荐文章</h3>
        </div>
        <div class="list-group recommnad-list">
            @foreach($articles as $article)
                <a href="{{ route('article-v2', ['url_name' => $article->url_name ]) }}" class="list-group-item">
                    <div class="info-box">
                        <div class="list-group-row">
                            <p class="title">{{ $article->title }}</p>
                        </div>
                        <div class="list-group-row">
                            <ul class="meta-list">
                                @if(!empty($article->tags))
                                    <li class="meta-item">
                                        @foreach($article->tags as $tag)
                                            <span class="label label-success">{{ $tag->tag_name }}</span>
                                        @endforeach
                                    </li>
                                @endif
                                <li class="meta-item">{{ $article->user->name }}</li>
                                <li class="meta-item">{{ diff_time($article->updated_at) }}</li>
                            </ul>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="panel-body">
            {{-- 分页 --}}
            {{ $articles->links() }}
        </div>
    </div>
</div>
<div class="col-md-3 mark-content hidden-xs">
    @include('block.tag-panel')
</div>
@endsection