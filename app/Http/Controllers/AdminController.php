<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\AdminModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $admin = AdminModel::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Admin retrieved successfully',
                'data' => $admin,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve admin',
                'error' => 'An error occurred while retrieving admin'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create user
            $user = UserModel::create([
                'email' => $request->nip . '@polinema.ac.id',
                'password' => Hash::make($request->nip),
                'role' => 'admin',
                'status_akun' => 'aktif',
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Combine validated data and user_id
            $data = $request->validated();
            $data['user_id'] = $user->user_id;

            // Create admin
            $admin = AdminModel::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Admin created successfully',
                'data' => [$admin, $user]
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($nip)
    {
        try {
            $admin = AdminModel::findOrFail($nip);

            return response()->json([
                'success' => true,
                'message' => 'Admin retrieved successfully',
                'data' => $admin
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateAdminRequest $request, $nip)
    {
        try {
            $admin = AdminModel::findOrFail($nip);
            $validatedData = $request->validated();

            $admin->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Admin updated successfully',
                'data' => $admin->fresh()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found',
                'error' => 'The requested admin does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $admin = AdminModel::findOrFail($id);
            $user = UserModel::findOrFail($admin->user_id);

            $admin->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Admin deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Admin not found',
                'error' => 'The requested admin does not exist'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function indexView()
    {
        $breadcrumbs = [
            ['name' => 'Admin', 'url' => route('admin.manajemen-pengguna.admin.index')],
        ];
        return view('admin.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Admin'
        ]);
    }

    public function createView()
    {
        return view('admin.modals.create');
    }

    public function editView(string $id)
    {
        return view('admin.modals.edit', [
            'admin' => AdminModel::findOrFail($id),
        ]);
    }

    public function deleteView(string $id)
    {
        return view('admin.modals.delete', [
            'admin' => AdminModel::findOrFail($id),
        ]);
    }
}
