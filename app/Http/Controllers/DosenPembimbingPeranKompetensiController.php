<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteDosenPembimbingPeranKompetensiRequest;
use App\Http\Requests\StoreDosenPembimbingPeranKompetensiRequest;
use App\Models\DosenPembimbingModel;
use App\Models\DosenPembimbingPeranKompetensiModel;
use App\Models\DosenPembimbingPeranModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DosenPembimbingPeranKompetensiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = $request->user()->user_id;
            $nip = DosenPembimbingModel::where('user_id', $userId)->get()[0]->nip;
            $peranIds = DosenPembimbingPeranModel::where('nip', $nip)->pluck('peran_id');

            $dosenPembimbingPeranKompetensi = DosenPembimbingPeranKompetensiModel::whereIn('peran_id', $peranIds)->get();

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi retrieved successfully',
                'data' => $dosenPembimbingPeranKompetensi
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreDosenPembimbingPeranKompetensiRequest $request, $peranId)
    {
        try {
            $data = $request->validated();
            $data['peran_id'] = (int) $peranId;

            $dosenPembimbingPeranKompetensi = DosenPembimbingPeranKompetensiModel::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi created successfully',
                'data' => $dosenPembimbingPeranKompetensi
            ], 201);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to create kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $peranId)
    {
        try {
            $userId = $request->user()->user_id;
            $nip = DosenPembimbingModel::where('user_id', $userId)->get()[0]->nip;
            $peranId = DosenPembimbingPeranModel::where('nip', $nip)->where('peran_id', $peranId)->get()[0]->peran_id;

            $dosenPembimbingPeranKompetensi = DosenPembimbingPeranKompetensiModel::where('peran_id', $peranId)->get();

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi retrieved successfully',
                'data' => $dosenPembimbingPeranKompetensi
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(DeleteDosenPembimbingPeranKompetensiRequest $request, $peranId)
    {
        try {
            $userId = $request->user()->user_id;
            $nip = DosenPembimbingModel::where('user_id', $userId)->first()?->nip;

            $peran = DosenPembimbingPeranModel::where('nip', $nip)
                ->where('peran_id', $peranId)
                ->firstOrFail();

            $kompetensiId = $request->input('kompetensi_id');

            if ($kompetensiId) {
                // Hapus satu kompetensi spesifik
                DosenPembimbingPeranKompetensiModel::where('peran_id', $peran->peran_id)
                    ->where('kompetensi_id', $kompetensiId)
                    ->delete();

                $message = 'Kompetensi berhasil dihapus';
            } else {
                // Hapus semua kompetensi yang terkait dengan peran ini
                DosenPembimbingPeranKompetensiModel::where('peran_id', $peran->peran_id)->delete();

                $message = 'Semua kompetensi berhasil dihapus';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Peran atau kompetensi tidak ditemukan',
                'error' => 'The requested resource does not exist'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
