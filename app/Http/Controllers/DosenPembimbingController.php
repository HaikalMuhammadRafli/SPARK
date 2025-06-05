<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDosenPembimbingRequest;
use App\Http\Requests\UpdateDosenPembimbingRequest;
use App\Models\DosenPembimbingModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenPembimbingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dosen_pembimbing = DosenPembimbingModel::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Dosen retrieved successfully',
                'data' => $dosen_pembimbing,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dosen',
                'error' => 'An error occurred while retrieving dosen'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDosenPembimbingRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create user
            $user = UserModel::create([
                'email' => $request->nip . '@polinema.ac.id',
                'password' => Hash::make($request->nip),
                'role' => 'dosen',
                'status_akun' => 'aktif',
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Combine validated data and user_id
            $data = $request->validated();
            $data['user_id'] = $user->user_id;

            // Create dosen
            $dosen_pembimbing = DosenPembimbingModel::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dosen created successfully',
                'data' => [$dosen_pembimbing, $user]
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create dosen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $dosen_pembimbing = DosenPembimbingModel::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Dosen retrieved successfully',
                'data' => $dosen_pembimbing
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dosen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateDosenPembimbingRequest $request, $nip)
    {
        try {
            $dosen_pembimbing = DosenPembimbingModel::findOrFail($nip);
            $validatedData = $request->validated();

            $dosen_pembimbing->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Dosen updated successfully',
                'data' => $dosen_pembimbing->fresh()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dosen not found',
                'error' => 'The requested dosen does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update dosen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $dosen_pembimbing = DosenPembimbingModel::findOrFail($id);
            $user = UserModel::findOrFail($dosen_pembimbing->user_id);

            $dosen_pembimbing->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dosen deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Dosen not found',
                'error' => 'The requested dosen does not exist'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete dosen',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function indexView()
    {
        $breadcrumbs = [
            ['name' => 'Dosen Pembimbing', 'url' => route('admin.manajemen-pengguna.dosen-pembimbing.index')],
        ];
        return view('dosen-pembimbing.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Dosen Pembimbing'
        ]);
    }

    public function createView()
    {
        return view('dosen-pembimbing.modals.create');
    }

    public function editView(string $id)
    {
        return view('dosen-pembimbing.modals.edit', [
            'dosenPembimbing' => DosenPembimbingModel::findOrFail($id),
        ]);
    }

    public function deleteView(string $id)
    {
        return view('dosen-pembimbing.modals.delete', [
            'dosenPembimbing' => DosenPembimbingModel::findOrFail($id),
        ]);
    }
}
