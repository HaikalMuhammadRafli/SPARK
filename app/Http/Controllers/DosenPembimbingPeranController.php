<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDosenPembimbingPeranRequest;
use App\Http\Requests\UpdateDosenPembimbingPeranRequest;
use App\Models\DosenPembimbingModel;
use App\Models\DosenPembimbingPeranKompetensiModel;
use App\Models\DosenPembimbingPeranModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DosenPembimbingPeranController extends Controller
{
    public function index()
    {
        try {
            $dosenPembimbingPeran = DosenPembimbingPeranModel::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Peran retrieved successfully',
                'data' => $dosenPembimbingPeran,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve peran',
                'error' => 'An error occurred while retrieving peran'
            ], 500);
        }
    }

    public function store(StoreDosenPembimbingPeranRequest $request)
    {
        try {
            $userId = $request->user()->user_id;
            $nip = DosenPembimbingModel::where('user_id', $userId)->get()[0]->nip;

            $data = $request->validated();
            $data['nip'] = $nip;

            $dosenPembimbingPeran = DosenPembimbingPeranModel::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Peran created successfully',
                'data' => $dosenPembimbingPeran
            ], 201);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to create peran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $userId = $request->user()->user_id;
            $nip = DosenPembimbingModel::where('user_id', $userId)->get()[0]->nip;
            $dosenPembimbingPeran = DosenPembimbingPeranModel::where('nip', $nip)->get();

            return response()->json([
                'success' => true,
                'message' => 'Peran retrieved successfully',
                'data' => $dosenPembimbingPeran
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve peran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateDosenPembimbingPeranRequest $request, $peranId)
    {
        try {
            $userId = $request->user()->user_id;
            $nip = DosenPembimbingModel::where('user_id', $userId)->get()[0]->nip;
            $peranId = DosenPembimbingPeranModel::where('nip', $nip)->where('peran_id', $peranId)->get()[0]->peran_id;

            $dosenPembimbingPeran = DosenPembimbingPeranModel::findOrFail($peranId);

            $validatedData = $request->validated();

            $dosenPembimbingPeran->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Peran updated successfully',
                'data' => $dosenPembimbingPeran->fresh()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Peran not found',
                'error' => 'The requested peran does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update peran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $peranId)
    {
        try {
            $userId = $request->user()->user_id;
            $nip = DosenPembimbingModel::where('user_id', $userId)->get()[0]->nip;
            $peranId = DosenPembimbingPeranModel::where('nip', $nip)->where('peran_id', $peranId)->get()[0]->peran_id;

            $dosenPembimbingPeran = DosenPembimbingPeranModel::findOrFail($peranId);

            $dosenPembimbingPeran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Peran deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Peran not found',
                'error' => 'The requested peran does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete peran',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function indexView()
    {
        $breadcrumbs = [
            ['name' => 'Dosen Pembimbing', 'url' => route('dosen-pembimbing.kelompok-bimbingan.index')],
        ];
        return view('kelompok-bimbingan.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Kelompok Bimbingan'
        ]);
    }

    public function createView()
    {
        return view('kelompok-bimbingan.modals.create');
    }

    public function editView(string $id)
    {
        return view('kelompok-bimbingan.modals.edit', [
            'dosenPembimbingPeran' => DosenPembimbingPeranModel::findOrFail($id),
            'dosenPembimbingPeranKompetensi' => DosenPembimbingPeranKompetensiModel::where('peran_id', DosenPembimbingPeranModel::findOrFail($id)->peran_id)->get(),
        ]);
    }

    public function deleteView(string $id)
    {
        return view('kelompok-bimbingan.modals.delete', [
            'dosenPembimbingPeran' => DosenPembimbingPeranModel::findOrFail($id),
        ]);
    }
}
