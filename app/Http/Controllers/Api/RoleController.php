<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = $this->role->with('permissions')->paginate($request->input('pageSize', 30));
        return response()->api($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        $data = $request->only('name');
        $this->role::create($data);
        if ($request->has('permission_names'))
        {
            $this->role->syncPermissions($request->input('permission_names'));
        }
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
        $data = $this->role->with('permissions')->find($id);
        return response()->api($data);
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
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        $data = $request->only('name');
        $model = $this->role->find($id);
        $model->name = $data['name'];
        $model->save();
        if ($request->has('permission_names'))
        {
            $model->syncPermissions($request->input('permission_names'));
        }
        return response()->api();
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
