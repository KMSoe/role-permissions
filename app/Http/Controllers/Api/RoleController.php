<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage_roles')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleRepository $repo)
    {
        $user = Auth::user();

        $data = $repo->getByUser($user->id);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function roleList(RoleRepository $repo)
    {

        $data = $repo->all();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RoleRepository $repo)
    {
        $data = [
            'name' => $request->name
        ];

        $item = $repo->store((object)$data);

        return response()->json([
            'status' => true,
            'data' => $item,
            'message' => 'Created Successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, RoleRepository $repo)
    {
        $item = $repo->show($id);

        return response()->json([
            'status' => true,
            'data' => $item,
            'message' => ''
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, RoleRepository $repo)
    {
        $data = [
            'name' => $request->name
        ];

        $item = $repo->update($id, (object)$data);

        return response()->json([
            'status' => true,
            'data' => $item,
            'message' => 'Updated Successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, RoleRepository $repo)
    {
        $item = $repo->destroy($id);

        return response()->json([], 204);
    }
}
