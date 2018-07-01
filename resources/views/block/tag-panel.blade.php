<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">热门标签</h3>
    </div>
    <div class="panel-body">
        @foreach($tags as $tag)
        <a href="{{ route('tag', ['id' => $tag->id]) }}" class="btn btn-default btn-sm btn-category">{{ $tag->tag_name }}</a>
        @endforeach
    </div>
</div>