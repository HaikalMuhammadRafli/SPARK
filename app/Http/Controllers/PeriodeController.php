<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodeStoreRequest;
use App\Http\Requests\PeriodeUpdateRequest;
use App\Models\PeriodeModel;
use Exception;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Periode', 'url' => route('admin.master.periode.index')],
        ];

        return view('periode.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Periode',
            'periodes' => PeriodeModel::all(),
        ]);
    }

    public function data()
    {
        $periodes = PeriodeModel::all();

        return response()->json([
            'status' => true,
            'data' => $periodes->map(function ($item, $index) {
                $currentYear = date('Y');
                $isActive = $currentYear >= $item->periode_tahun_awal && $currentYear <= $item->periode_tahun_akhir;
                
                return [
                    'no' => $index + 1,
                    'id' => $item->periode_id,
                    'nama' => $item->periode_nama,
                    'tahun_awal' => $item->periode_tahun_awal,
                    'tahun_akhir' => $item->periode_tahun_akhir,
                    'status' => $isActive ? 
                        '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"/>
                            </svg>
                            Aktif
                        </span>' :
                        '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"/>
                            </svg>
                            Tidak Aktif
                        </span>',
                    'actions' => view('components.buttons.action', [
                        'route_prefix' => 'admin.master.periode',
                        'id' => $item->periode_id
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
        return view('periode.modals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PeriodeStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            PeriodeModel::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Periode berhasil ditambahkan!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Periode gagal ditambahkan!, ' . $e->getMessage(),
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
        return view('periode.modals.edit', [
            'periode' => PeriodeModel::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PeriodeUpdateRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            $periode = PeriodeModel::findOrFail($id);
            $periode->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Periode berhasil diperbarui!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Periode gagal diperbarui!, ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        return view('periode.modals.delete', [
            'periode' => PeriodeModel::findOrFail($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $periode = PeriodeModel::findOrFail($id);
            $periode->delete();

            return response()->json([
                'status' => true,
                'message' => 'Periode berhasil dihapus!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Periode gagal dihapus!, ' . $e->getMessage(),
            ]);
        }
    }
}