<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Http\Resources\InventoryResource;
use Illuminate\Support\Facades\Storage;
use App\Models\InventoryFile;
use App\Helpers\ApiResponse;

class InventoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventories = Inventory::with([
            'member.department',
            'member.position',
            'files'
        ])
            ->when(
                $request->search,
                fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            )
            ->paginate(10);

        return ApiResponse::success(
            InventoryResource::collection($inventories),
            'Inventory list retrieved successfully',
            200,
            [
                'current_page' => $inventories->currentPage(),
                'last_page' => $inventories->lastPage(),
                'per_page' => $inventories->perPage(),
                'total' => $inventories->total(),
            ]
        );
    }

    public function analytics()
    {
        return response()->json([
            'total_inventory' => Inventory::count(),

            'status' => [
                'baik' => Inventory::where('status', 'baik')->count(),
                'rusak' => Inventory::where('status', 'rusak')->count(),
                'dilelang' => Inventory::where('status', 'dilelang')->count(),
                'tidak_dipakai' => Inventory::where('status', 'tidak_dipakai')->count(),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryRequest $request)
    {
        $data = $request->safe()->except(['files']);
        $inventory = Inventory::create($data);


        // Upload files if exists
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('inventories', 'public');
                InventoryFile::create([
                    'inventory_id' => $inventory->id,
                    'file_name'    => $file->getClientOriginalName(),
                    'file_path'    => $path,
                    'file_type'    => $file->getClientMimeType(),
                    'file_size'    => $file->getSize(),
                ]);
            }
        }

        return ApiResponse::success(
            new InventoryResource($inventory->load(['member', 'files'])),
            'Inventory created successfully',
            201
        );
    }
    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        return ApiResponse::success(
            new InventoryResource($inventory->load(['member', 'files'])),
            'Inventory detail retrieved successfully'
        );
    }


    /**
     * Update the specified inventory.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        // Ambil semua field yang bisa diupdate
        $fields = [
            'inventory_code',
            'name',
            'type',
            'serial_number',
            'specification',
            'status',
            'member_id',
        ];

        $data = [];
        foreach ($fields as $field) {
            // Hanya ambil field jika ada di request dan tidak null/empty string
            if ($request->has($field) && $request->filled($field)) {
                $data[$field] = $request->input($field);
            }
            // Jika ingin bisa set null juga, bisa pakai:
            // elseif ($request->has($field) && $request->input($field) === null) {
            //     $data[$field] = null;
            // }
        }

        // Update inventory
        $inventory->update($data);

        // Handle file upload jika ada
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('inventories', 'public');

                InventoryFile::create([
                    'inventory_id' => $inventory->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Load relasi untuk response
        $inventory->load(['member', 'files']);

        // Response konsisten
        return ApiResponse::success(
            new InventoryResource($inventory),
            'Inventory updated successfully'
        );
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        // Hapus file terkait dari storage
        foreach ($inventory->files as $file) {
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        }

        $inventory->delete();

        return ApiResponse::success(
            null,
            'Inventory deleted successfully'
        );
    }
}
