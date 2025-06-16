<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\MahasiswaModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $mahasiswa = MahasiswaModel::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa retrieved successfully',
                'data' => $mahasiswa,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve mahasiswa',
                'error' => 'An error occurred while retrieving mahasiswa'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMahasiswaRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create user
            $user = UserModel::create([
                'email' => $request->nim . '@polinema.ac.id',
                'password' => Hash::make($request->nim),
                'role' => 'mahasiswa',
                'status_akun' => 'aktif',
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Combine validated data and user_id
            $data = $request->validated();
            $data['user_id'] = $user->user_id;

            // Create mahasiswa
            $mahasiswa = MahasiswaModel::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa created successfully',
                'data' => [$mahasiswa, $user]
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $mahasiswa = MahasiswaModel::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa retrieved successfully',
                'data' => $mahasiswa
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateMahasiswaRequest $request, $nim)
    {
        try {
            $mahasiswa = MahasiswaModel::findOrFail($nim);
            $validatedData = $request->validated();

            $mahasiswa->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa updated successfully',
                'data' => $mahasiswa->fresh()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa not found',
                'error' => 'The requested mahasiswa does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $mahasiswa = MahasiswaModel::findOrFail($id);
            $user = UserModel::findOrFail($mahasiswa->user_id);

            $mahasiswa->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa not found',
                'error' => 'The requested mahasiswa does not exist'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function indexView()
    {
        $breadcrumbs = [
            ['name' => 'Mahasiswa', 'url' => route('admin.manajemen-pengguna.mahasiswa.index')],
        ];
        return view('mahasiswa.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Mahasiswa'
        ]);
    }

    public function createView()
    {
        return view('mahasiswa.modals.create');
    }

    public function editView(string $id)
    {
        return view('mahasiswa.modals.edit', [
            'mahasiswa' => MahasiswaModel::findOrFail($id),
        ]);
    }

    public function deleteView(string $id)
    {
        return view('mahasiswa.modals.delete', [
            'mahasiswa' => MahasiswaModel::findOrFail($id),
        ]);
    }

    public function exportPdf()
    {
        $mahasiswa = MahasiswaModel::select('nim', 'nama', 'lokasi_preferensi','user_id', 'program_studi_id')
            ->orderBy('nim')
            ->with(['user'])
            ->with(['program_studi'])
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('mahasiswa.export_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption('isRemoteEnabled', true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Mahasiswa ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
