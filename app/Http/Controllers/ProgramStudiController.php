<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramStudiStoreRequest;
use App\Http\Requests\ProgramStudiUpdateRequest;
use App\Models\ProgramStudiModel;
use Exception;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Program Studi', 'url' => route('admin.master.program-studi.index')],
        ];

        return view('program_studi.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Program Studi',
            'program_studis' => ProgramStudiModel::all(),
        ]);
    }

    public function data()
    {
        $program_studis = ProgramStudiModel::all();

        return response()->json([
            'status' => true,
            'data' => $program_studis->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'id' => $item->program_studi_id,
                    'nama' => $item->program_studi_nama,
                    'actions' => view('components.buttons.action', [
                        'route_prefix' => 'admin.master.program-studi',
                        'id' => $item->program_studi_id,
                        'showDetail' => false,
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
        return view('program_studi.modals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProgramStudiStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            ProgramStudiModel::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Program studi berhasil ditambahkan!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Program studi gagal ditambahkan!, ' . $e->getMessage(),
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
        return view('program_studi.modals.edit', [
            'program_studi' => ProgramStudiModel::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProgramStudiUpdateRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            $programStudi = ProgramStudiModel::findOrFail($id);
            $programStudi->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Program studi berhasil diperbarui!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Program studi gagal diperbarui!, ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        return view('program_studi.modals.delete', [
            'program_studi' => ProgramStudiModel::findOrFail($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $programStudi = ProgramStudiModel::findOrFail($id);
            $programStudi->delete();

            return response()->json([
                'status' => true,
                'message' => 'Program studi berhasil dihapus!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Program studi gagal dihapus!, ' . $e->getMessage(),
            ]);
        }
    }
}
