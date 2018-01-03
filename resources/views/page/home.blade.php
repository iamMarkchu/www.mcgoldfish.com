@extends('layouts.page')
@section('main_content')
<div class="col-md-9 col-sm-12 mark-content">
    <div class="panel panel-default">
        <div class="panel-heading">热门文章</div>
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
                                    <li class="meta-item"><span class="label label-success">{{ $article->category->category_name }}</span></li>
                                @endif
                                <li class="meta-item">{{ $article->user->name }}</li>
                                <li class="meta-item">{{ diff_time($article->updated_at) }}</li>
                            </ul>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
<div class="col-md-3">
    {{--侧边栏--}}
    <div class="panel panel-default">
        <div class="panel-heading">热门分类</div>
        <div class="panel-body">
            @foreach($categories as $category)
                <a href="" class="label label-primary">{{ $category->category_name }}</a>
            @endforeach
        </div>
    </div>
</div>
@endsection