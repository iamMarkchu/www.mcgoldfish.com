<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreTagRequest;

class TagController extends Controller
{

    /**
     * @var TagRepository
     */
    private $tag;

    public function __construct(TagRepository $tag)
    {

        $this->tag = $tag;
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $map = [];
        $result = $this->tag->fetchList($map, $request->input('pageSize', 30));
        return Response::api($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        $data = $this->handleRequest($request);
        $this->tag->create($data);
        return response()->api('创建成功!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Response::api($this->tag->find($id));
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
        $data = $this->handleRequest($request);
        $tag = $this->tag->update($data, $id);
        if ($tag)
            return Response::api(['id' => $id]);
        else
            return Response::api(['id' => $id], 500);
    }

    protected function handleRequest(Request $request)
    {
        $data = $request->only(
            $this->tag->getFillable()
        );
        return $data;
    }
}
