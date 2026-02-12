<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Helpers\ApiResponse;

class DepartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::paginate(10);

        return ApiResponse::success(
            DepartmentResource::collection($departments),
            'Department list retrieved successfully',
            200,
            [
                'current_page' => $departments->currentPage(),
                'last_page' => $departments->lastPage(),
                'per_page' => $departments->perPage(),
                'total' => $departments->total(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->validated());

        return ApiResponse::success(
            new DepartmentResource($department),
            'Department created successfully',
            201
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return ApiResponse::success(
            new DepartmentResource($department),
            'Department detail retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());

        return ApiResponse::success(
            new DepartmentResource($department),
            'Department updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return ApiResponse::success(
            null,
            'Department deleted successfully'
        );
    }
}
