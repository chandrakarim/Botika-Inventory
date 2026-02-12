<?php

namespace App\Http\Controllers\Api;

use App\Models\Position;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Http\Resources\PositionResource;
use App\Helpers\ApiResponse;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::paginate(10);

        return ApiResponse::success(
            PositionResource::collection($positions),
            'Position list retrieved successfully',
            200,
            [
                'current_page' => $positions->currentPage(),
                'last_page' => $positions->lastPage(),
                'per_page' => $positions->perPage(),
                'total' => $positions->total(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        $position = Position::create($request->validated());

        return ApiResponse::success(
            new PositionResource($position),
            'Position created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        return ApiResponse::success(
            new PositionResource($position),
            'Position detail retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $position->update($request->validated());

        return ApiResponse::success(
            new PositionResource($position),
            'Position updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return ApiResponse::success(
            null,
            'Position deleted successfully'
        );
    }
}
