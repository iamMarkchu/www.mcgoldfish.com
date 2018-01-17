@if(request()->route()->getName() === 'article-v2')
    <div class="columen-view-fixed hidden-xs hidden-sm hidden-md">
        <ul class="article-suspending-panel">
            <li>
                <a href="javascript:;" class="vote" data-article-id="{{ $article->id }}"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                <span class="vote_count">{{ $article->vote_count }}</span>
            </li>
            <li>
                <a href="#comment" title="评论"><i class="fa fa-commenting-o" aria-hidden="true"></i></a>
            </li>
            <li>
                <a href="javascript:;" class="wx-share" title="分享到微信" data-article-id="{{ $article->id }}"><i class="fa fa-weixin" aria-hidden="true"></i></a>
                <div class="qrcode hidden no_qrcode">
                    <div class="loading">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
@endif