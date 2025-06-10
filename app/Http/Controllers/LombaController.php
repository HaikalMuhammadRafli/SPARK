<?php

namespace App\Http\Controllers;

use App\Http\Requests\LombaStoreRequest;
use App\Http\Requests\LombaUpdateRequest;
use App\Models\LombaModel;
use App\Models\PeriodeModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Lomba', 'url' => route('admin.manajemen.lomba.index')],
        ];

        return view('lomba.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Data Lomba',
            'lombas' => LombaModel::with('periode')->get(),
        ]);
    }

    public function data()
    {
        $lombas = LombaModel::with('periode')->get();

        return response()->json([
            'status' => true,
            'data' => $lombas->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'id' => $item->lomba_id,
                    'nama' => $item->lomba_nama,
                    'kategori' => $item->lomba_kategori,
                    'penyelenggara' => $item->lomba_penyelenggara,
                    'tingkat' => $item->lomba_tingkat,
                    'lokasi' => $item->lomba_lokasi_preferensi,
                    'mulai_pendaftaran' => $item->lomba_mulai_pendaftaran->format('d/m/Y'),
                    'akhir_pendaftaran' => $item->lomba_akhir_pendaftaran->format('d/m/Y'),
                    'status' => ucfirst($item->lomba_status),
                    'actions' => view('components.buttons.action', [
                        'route_prefix' => 'admin.manajemen.lomba',
                        'id' => $item->lomba_id
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
        return view('lomba.modals.create', [
            'periodes' => PeriodeModel::all(),
            'action' => route('admin.manajemen.lomba.store'),
            'method' => 'POST',
            'buttonText' => 'Tambah Lomba',
            'buttonIcon' => 'fa-solid fa-plus'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LombaStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Handle poster upload
            if ($request->hasFile('lomba_poster')) {
                $file = $request->file('lomba_poster');
                
                // Validate file
                if (!$file->isValid()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'File poster tidak valid!'
                    ]);
                }
                
                // Check file size (max 2MB)
                if ($file->getSize() > 2 * 1024 * 1024) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Ukuran file poster maksimal 2MB!'
                    ]);
                }
                
                // Check file type
                $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Format file harus JPG, JPEG, atau PNG!'
                    ]);
                }
                
                // Generate unique filename
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store file
                $posterPath = $file->storeAs('lomba/posters', $fileName, 'public');
                $validated['lomba_poster_url'] = $posterPath;
            }

            // Remove lomba_poster from validated data since we're using lomba_poster_url
            unset($validated['lomba_poster']);

            LombaModel::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Data lomba berhasil ditambahkan!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data lomba gagal ditambahkan! ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('lomba.modals.show', [
            'lomba' => LombaModel::with('periode')->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('lomba.modals.edit', [
            'lomba' => LombaModel::findOrFail($id),
            'periodes' => PeriodeModel::all(),
            'action' => route('admin.manajemen.lomba.update', $id),
            'method' => 'PUT',
            'buttonText' => 'Update Lomba',
            'buttonIcon' => 'fa-solid fa-save'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LombaUpdateRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            $lomba = LombaModel::findOrFail($id);
            
            // Handle poster upload
            if ($request->hasFile('lomba_poster')) {
                $file = $request->file('lomba_poster');
                
                // Validate file
                if (!$file->isValid()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'File poster tidak valid!'
                    ]);
                }
                
                // Check file size (max 2MB)
                if ($file->getSize() > 2 * 1024 * 1024) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Ukuran file poster maksimal 2MB!'
                    ]);
                }
                
                // Check file type
                $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Format file harus JPG, JPEG, atau PNG!'
                    ]);
                }
                
                // Delete old poster if exists
                if ($lomba->lomba_poster_url && Storage::disk('public')->exists($lomba->lomba_poster_url)) {
                    Storage::disk('public')->delete($lomba->lomba_poster_url);
                }
                
                // Generate unique filename
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store new file
                $posterPath = $file->storeAs('lomba/posters', $fileName, 'public');
                $validated['lomba_poster_url'] = $posterPath;
            }

            // Remove lomba_poster from validated data since we're using lomba_poster_url
            unset($validated['lomba_poster']);
            
            $lomba->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Data lomba berhasil diperbarui!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data lomba gagal diperbarui! ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        return view('lomba.modals.delete', [
            'lomba' => LombaModel::findOrFail($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $lomba = LombaModel::findOrFail($id);
            
            // Delete poster file if exists
            if ($lomba->lomba_poster_url && Storage::disk('public')->exists($lomba->lomba_poster_url)) {
                Storage::disk('public')->delete($lomba->lomba_poster_url);
            }
            
            $lomba->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data lomba berhasil dihapus!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data lomba gagal dihapus! ' . $e->getMessage(),
            ]);
        }
    }
}