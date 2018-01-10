@if(request()->route()->getName() === 'article')
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
                <a href="javascript:;" class="wx-share" title="分享到微信"><i class="fa fa-weixin" aria-hidden="true"></i></a>
                <div class="qrcode hidden">
                    {!! QrCode::size(100)->generate(Request::url()); !!}
                </div>
            </li>
        </ul>
    </div>
@endif