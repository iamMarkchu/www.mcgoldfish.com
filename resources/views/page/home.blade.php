@extends('layouts.page')
@section('main_content')
<div class="col-md-9 col-sm-12 mark-content">
    <div class="panel panel-default">
        <div class="panel-heading">文章列表</div>
        <div class="list-group">
            @foreach($articles as $article)
                <a href="{{ route('article', ['id' => $article->id ]) }}" class="list-group-item">
                    <div class="info-box">
                        <div class="list-group-row">
                            <p class="title">{{ $article->title }}</p>
                        </div>
                        <div class="list-group-row">
                            <ul class="meta-list">
                                @if(isset($article->category))
                                    <li class="meta-item"><span class="label label-primary">{{ $article->category->category_name }}</span></li>
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
<div class="col-md-3 mark-content hidden-xs">
    @include('block.category-panel')
</div>
@endsection