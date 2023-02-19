<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionRepository $repo)
    {
        $this->authorize('viewAny', Permission::class);

        $user = Auth::user();

        $data = $repo->getByUser($user->id);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function permissionList(PermissionRepository $repo)
    {
        $this->authorize('permissionList', Permission::class);

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
    public function store(Request $request, PermissionRepository $repo)
    {
        $this->authorize('create', Permission::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'assign_roles' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Fail'
            ], 422);
        }
        
        $data = [
            'name' => $request->name,
            'assign_roles' => $request->assign_roles
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
    public function show($id, PermissionRepository $repo)
    {
        $this->authorize('view', Permission::class);

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
    public function update(Request $request, $id, PermissionRepository $repo)
    {
        $this->authorize('update', Permission::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'assign_roles' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Fail'
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'assign_roles' => $request->assign_roles
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
    public function destroy($id, PermissionRepository $repo)
    {
        $this->authorize('delete', Permission::class);

        $item = $repo->destroy($id);

        return response()->json([], 204);
    }
}
