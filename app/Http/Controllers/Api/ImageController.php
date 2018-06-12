<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Image $image
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Image $image)
    {
        $list = $image->orderBy('id', 'desc')->paginate($request->input('pageSize', 30));
        return response()->api($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image $image
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Image $image)
    {
        $image->user_id = Auth::id();
        $image->name = empty($request->input('name'))? '': $request->input('name');
        $image->description = '';
        $image->url_name = $request->input('url_name');
        $image->status = 'active';
        $image->display_order = 99;
        $image->save();
        return response()->api($image);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
