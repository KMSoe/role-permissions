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
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleRepository $repo)
    {
        $this->authorize('viewAny', Role::class);
        $user = Auth::user();

        $data = $repo->getByUser($user->id);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function roleList(RoleRepository $repo)
    {
        $this->authorize('roleList', Role::class);

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
        $this->authorize('create', Role::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Fail'
            ], 422);
        }

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
        $this->authorize('view', Role::class);

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
        $this->authorize('update', Role::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Fail'
            ], 422);
        }

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
    public function destroy(RoleRepository $repo, $id)
    {
        $this->authorize('delete', Role::class);

        $item = $repo->destroy($id);

        return response()->json([], 204);
    }
}
