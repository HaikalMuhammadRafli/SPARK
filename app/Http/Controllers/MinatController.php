<?php

namespace App\Http\Controllers;

use App\Http\Requests\MinatStoreRequest;
use App\Http\Requests\MinatUpdateRequest;
use App\Models\MinatModel;
use Exception;
use Illuminate\Http\Request;

class MinatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Minat', 'url' => route('admin.master.minat.index')],
        ];

        return view('minat.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Minat',
            'minats' => MinatModel::all(),
        ]);
    }

    public function data()
    {
        $minats = MinatModel::all();

        return response()->json([
            'status' => true,
            'data' => $minats->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'id' => $item->minat_id,
                    'nama' => $item->minat_nama,
                    'actions' => view('components.buttons.action', [
                        'route_prefix' => 'admin.master.minat',
                        'id' => $item->minat_id
                    ])->render()
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('minat.modals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MinatStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            MinatModel::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Minat berhasil ditambahkan!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Minat gagal ditambahkan!, ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('minat.modals.edit', [
            'minat' => MinatModel::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MinatUpdateRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            $minat = MinatModel::findOrFail($id);
            $minat->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Minat berhasil diperbarui!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Minat gagal diperbarui!, ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        return view('minat.modals.delete', [
            'minat' => MinatModel::findOrFail($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $minat = MinatModel::findOrFail($id);
            $minat->delete();

            return response()->json([
                'status' => true,
                'message' => 'Minat berhasil dihapus!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Minat gagal dihapus!, ' . $e->getMessage(),
            ]);
        }
    }
}