@extends('layouts.app')
@section('content')
    <div id="content">
        <div class="container mark-container">
            {{--<div class="columen-view-fixed">--}}
                {{--<ul class="article-suspending-panel show">--}}
                    {{--<li>点赞</li>--}}
                    {{--<li><a href="#comment">评论</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            @yield('main_content')
        </div>
        <div class="dialog-block">
            <div class="modal fade message-dialog" tabindex="-1" role="dialog" aria-labelledby="messageDialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">消息提示</h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection