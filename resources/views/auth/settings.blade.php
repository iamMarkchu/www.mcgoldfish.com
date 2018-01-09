@extends('layouts.app')
@section('content')
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">个人设置</div>
                        <div class="panel-body">
                            <form>
                                <div class="form-group">
                                    <label for="avatar">用户头像：</label>
                                    <a class="btn btn-success fileinput-button">
                                        <span>上传图片</span>
                                        <input id="fileupload" type="file" name="files">
                                    </a>
                                </div>
                                <button type="submit" class="btn btn-success">确认</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    @parent
    <link rel="stylesheet" href="{{ mix('css/jquery-upload.css') }}">
    <script src="{{ mix('js/jquery-upload.js') }}"></script>
    <script>
        $(function(){
            $('#fileupload').fileupload({
                url: '/api/upload',
                singleFileUploads: true,
                beforeSend: function(xhr, data) {
                    xhr.setRequestHeader('X-FileName', file.name);
                },
                done: function(e, data) {

                }
            });
        })
    </script>
@stop