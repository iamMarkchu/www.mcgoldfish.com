@extends('layouts.page')
@section('main_content')
    <div class="col-md-12 mark-content">
        <div class="panel panel-default">
            <div class="panel-heading">{{ ucfirst($tag->tag_name) }}</div>
            <div class="list-group">
                @foreach($articles as $article)
                    <a href="{{ route('article-v2', ['url_name' => $article->url_name ]) }}" class="list-group-item">
                        <div class="info-box">
                            <div class="list-group-row">
                                <p class="title">{{ $article->title }}</p>
                            </div>
                            <div class="list-group-row">
                                <ul class="meta-list">
                                    @if(!empty($article->tags))
                                        @foreach($article->tags as $a_tag)
                                            <li class="meta-item"><span class="label label-success">{{ $a_tag->tag_name }}</span></li>
                                        @endforeach
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
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection