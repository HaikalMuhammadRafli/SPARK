<?php

namespace App\Http\Controllers;

use App\Http\Requests\KompetensiStoreRequest;
use App\Http\Requests\KompetensiUpdateRequest;
use App\Http\Requests\StoreKompetensiRequest;
use App\Http\Requests\UpdateKompetensiRequest;
use App\Models\KompetensiModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class KompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kompetensi = KompetensiModel::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi retrieved successfully',
                'data' => $kompetensi,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve kompetensi',
                'error' => 'An error occurred while retrieving kompetensi'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreKompetensiRequest $request)
    {
        try {
            $kompetensi = KompetensiModel::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi created successfully',
                'data' => $kompetensi
            ], 201);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to create kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $kompetensi = KompetensiModel::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi retrieved successfully',
                'data' => $kompetensi
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function update(UpdateKompetensiRequest $request, $id)
    {
        try {
            $kompetensi = KompetensiModel::findOrFail($id);
            $validatedData = $request->validated();

            $kompetensi->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi updated successfully',
                'data' => $kompetensi->fresh()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kompetensi not found',
                'error' => 'The requested kompetensi does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kompetensi = KompetensiModel::findOrFail($id);

            $kompetensi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kompetensi deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kompetensi not found',
                'error' => 'The requested kompetensi does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete kompetensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function indexView()
    {
        $breadcrumbs = [
            ['name' => 'Kompetensi', 'url' => route('admin.master.kompetensi.index')],
        ];
        return view('kompetensi.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Kompetensi'
        ]);
    }

    public function createView()
    {
        return view('kompetensi.modals.create');
    }

    public function editView(string $id)
    {
        return view('kompetensi.modals.edit', [
            'kompetensi' => KompetensiModel::findOrFail($id),
        ]);
    }

    public function deleteView(string $id)
    {
        return view('kompetensi.modals.delete', [
            'kompetensi' => KompetensiModel::findOrFail($id),
        ]);
    }
}
