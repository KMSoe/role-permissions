<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use App\Repositories\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StaffRepository $repo)
    {
        $this->authorize('viewAny', Staff::class);

        $staffs = $repo->all();

        return response()->json([
            'status' => true,
            'data' => $staffs
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByDepartment(StaffRepository $repo)
    {
        $this->authorize('viewByDepartment', Staff::class);

        $user = Auth::user();

        $department_id = Staff::where('id', $user->staff_id)
            ->first()
            ->department_id;

        $staffs = $repo->getByDepartment($department_id);

        return response()->json([
            'status' => true,
            'data' => $staffs
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StaffRepository $repo)
    {
        $user = Auth::user();

        $this->authorize('create', Staff::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'department_id' => 'required',
            'position' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required|in:male,female,others,prefer not to disclose'
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
            'email' => $request->email,
            'mobile' => $request->mobile,
            'department_id' => $request->department_id,
            'position' => $request->position,
            'age' => $request->age,
            'gender' => $request->gender,
            'created_by' => $user->id
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
    public function show($id, StaffRepository $repo)
    {
        $item = Staff::find($id);
        $this->authorize('view', $item);

        $data = $repo->show($id);

        return response()->json([
            'status' => true,
            'data' => $data,
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
    public function update(Request $request, $id, StaffRepository $repo)
    {
        $user = Auth::user();

        $item = Staff::find($id);
        $this->authorize('update', $item);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'department_id' => 'required',
            'position' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required|in:male,female,others,prefer not to disclose'
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
            'email' => $request->email,
            'mobile' => $request->mobile,
            'department_id' => $request->department_id,
            'position' => $request->position,
            'age' => $request->age,
            'gender' => $request->gender,
            'updated_by' => $user->id
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
    public function destroy($id, StaffRepository $repo)
    {
        $item = Staff::find($id);
        $this->authorize('delete', $item);

        $repo->destroy($id);

        return response()->json([], 204);
    }
}
