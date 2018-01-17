<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeController extends Controller
{
    /**
     * @param Request $request
     */
    public function show(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        if($type == 'article')
        {
            $article = Article::find($id);
            if(!empty($article))
                $html = QrCode::size(150)->generate(route('article-v2', ['url_name' => $article->url_name]));
        }
        if(!isset($html))
            $html = QrCode::size(150)->generate(route('index'));

        return response($html);
    }
}
