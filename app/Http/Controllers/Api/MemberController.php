<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Helpers\ApiResponse;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with(['department', 'position'])->paginate(10);

        return ApiResponse::success(
            MemberResource::collection($members),
            'Member list retrieved successfully',
            200,
            [
                'current_page' => $members->currentPage(),
                'last_page' => $members->lastPage(),
                'per_page' => $members->perPage(),
                'total' => $members->total(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $member = Member::create($request->validated());

        return ApiResponse::success(
            new MemberResource(
                $member->load(['department', 'position'])
            ),
            'Member created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return ApiResponse::success(
            new MemberResource(
                $member->load(['department', 'position'])
            ),
            'Member detail retrieved successfully'
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());

        return ApiResponse::success(
            new MemberResource(
                $member->load(['department', 'position'])
            ),
            'Member updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return ApiResponse::success(
            null,
            'Member deleted successfully'
        );
    }
}
