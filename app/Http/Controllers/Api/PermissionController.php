<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionRepository $repo)
    {
        $user = Auth::user();

        $data = $repo->getByUser($user->id);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function permissionList(PermissionRepository $repo)
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
    public function store(Request $request, PermissionRepository $repo)
    {
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
        $item = $repo->destroy($id);

        return response()->json([], 204);
    }
}
