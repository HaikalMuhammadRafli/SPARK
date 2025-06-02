<?php

namespace App\Http\Controllers;

use App\Http\Requests\BidangKeahlianStoreRequest;
use App\Http\Requests\BidangKeahlianUpdateRequest;
use App\Models\BidangKeahlianModel;
use Exception;
use Illuminate\Http\Request;

class BidangKeahlianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Bidang Keahlian', 'url' => route('admin.master.bidang-keahlian.index')],
        ];

        return view('bidang_keahlian.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Bidang Keahlian',
            'bidang_keahlians' => BidangKeahlianModel::all(),
        ]);
    }

    public function data()
    {
        $bidang_keahlians = BidangKeahlianModel::all();

        return response()->json([
            'status' => true,
            'data' => $bidang_keahlians->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'id' => $item->bidang_keahlian_id,
                    'nama' => $item->bidang_keahlian_nama,
                    'actions' => view('components.buttons.action', [
                        'route_prefix' => 'admin.master.bidang-keahlian',
                        'id' => $item->bidang_keahlian_id
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
        return view('bidang_keahlian.modals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BidangKeahlianStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            BidangKeahlianModel::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Bidang keahlian berhasil ditambahkan!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Bidang keahlian gagal ditambahkan!, ' . $e->getMessage(),
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
        return view('bidang_keahlian.modals.edit', [
            'bidang_keahlian' => BidangKeahlianModel::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BidangKeahlianUpdateRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            $bidangKeahlian = BidangKeahlianModel::findOrFail($id);
            $bidangKeahlian->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Bidang keahlian berhasil diperbarui!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Bidang keahlian gagal diperbarui!, ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        return view('bidang_keahlian.modals.delete', [
            'bidang_keahlian' => BidangKeahlianModel::findOrFail($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $bidangKeahlian = BidangKeahlianModel::findOrFail($id);
            $bidangKeahlian->delete();

            return response()->json([
                'status' => true,
                'message' => 'Bidang keahlian berhasil dihapus!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Bidang keahlian gagal dihapus!, ' . $e->getMessage(),
            ]);
        }
    }
}
