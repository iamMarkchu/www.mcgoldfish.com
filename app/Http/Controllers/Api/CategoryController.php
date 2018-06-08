<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        return response()->api($category->withCount('articles')->paginate($request->limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $this->handleRequest($request);
        $this->category->createOne($data);
        return response()->api();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->category->find($id);
        return response()->api($data);
    }

    /**
     * Update the specified resource in storage.
     * @param  int $category
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $data = $this->handleRequest($request);
        $flag = $this->category->updateItem($data, $id);
        if ($flag)
            return response()->api(['id' => $id]);
        else
            return response()->api(['id' => $id], 500);
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

    public function tree()
    {
        $categoryList = $this->category->get();
        $result = $this->treeItem($categoryList);
        return response()->api($result);
    }

    protected function treeItem($data, $pid=0)
    {
        $subItems = [];
        foreach ($data as $k => $d)
        {
            if ($d->parent_id == $pid)
            {
                unset($data[$k]);
                $d->children = $this->treeItem($data, $d->id);
                $subItems[] = $d;
            }
        }
        return $subItems;
    }

    protected function handleRequest(Request $request)
    {
        $data = $request->only(
            $this->category->getFillable()
        );
        $data['url_name'] = generate_url($request->category_name);
        return $data;
    }
}
