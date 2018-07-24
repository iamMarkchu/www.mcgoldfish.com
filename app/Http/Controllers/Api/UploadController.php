<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UploadController extends Controller
{
    //
    /**
     * @param Request $request
     * @param Image $image
     * @return String
     */
    public function qiniu(Request $request, Image $image)
    {
        $url = 'http://qiniu.mcgoldfish.com/';

        // 保存图片到七牛云
        $path = $request->file('file')->store(
            'image/'.$request->user()->id, 'qiniu'
        );

        $fullPath = $url. $path;

        // 保存到数据库
        $image->user_id = Auth::id();
        $image->name = $request->input('name', 'upload by api');
        $image->description = $request->input('description', '');
        $image->url_name = $fullPath;
        $image->status = 'active';
        $image->display_order = 99;
        $image->save();

        return Response::api($fullPath);
    }
}
