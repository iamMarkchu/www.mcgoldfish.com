<ul class="media-list comment-list">
    @foreach( $collection as $comment)
        <li class="media comment-block">
            <div class="media-left media-top">
                <a href="javascript:;">
                    <img class="media-object comment-avatar" width="48" src="{{ $comment->owner->avatar }}" alt="...">
                </a>
            </div>
            <div class="media-body">
                <p class="comment-heading">{{ $comment->owner->name }}</p>
                <p class="comment-body">{{ $comment->content }}</p>
                <ul class="comment-footer">
                    <li><a href="javascript:;" class="btn btn-info btn-xs comment-good" data-comment-id="{{ $comment->id }}">赞(<span class="good_count">{{ $comment->good_count }}</span>)</a></li>
                    <li class="hidden"><a href="" class="btn btn-primary btn-xs">回复</a></li>
                    <li>{{ diff_time($comment->created_at) }}</li>
                </ul>
            </div>
        </li>
    @endforeach
</ul>