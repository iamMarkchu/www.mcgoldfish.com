@if(request()->route()->getName() === 'article')
    <div class="modal fade loginDialog" tabindex="-1" role="dialog" aria-labelledby="loginDialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">登录之后才能评论</h4>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login', [ 'callback' => url()->current(), 'from' => 'comment']) }}" class="btn btn-success">登录</a>
                    <a href="{{ route('register', [ 'callback' => url()->current(),'form' => 'comment']) }}" class="btn btn-primary">注册</a>
                </div>
            </div>
        </div>
    </div>
@endif