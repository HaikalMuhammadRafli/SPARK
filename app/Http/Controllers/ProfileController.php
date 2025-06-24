<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileAddBidangKeahlianRequest;
use App\Http\Requests\ProfileAddMinatRequest;
use App\Http\Requests\ProfileMahasiswaUpdateRequest;
use App\Http\Requests\ProfileStaffUpdateRequest;
use App\Models\BidangKeahlianModel;
use App\Models\KeahlianDosenPembimbingModel;
use App\Models\KeahlianMahasiswaModel;
use App\Models\KompetensiModel;
use App\Models\MinatDosenPembimbingModel;
use App\Models\MinatMahasiswaModel;
use App\Models\MinatModel;
use Exception;
use Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', [
            'bidang_keahlians' => BidangKeahlianModel::all(),
            'minats' => MinatModel::all(),
            'kompetensis' => KompetensiModel::all(),
        ]);
    }

    public function edit()
    {
        return view('profile.modals.edit', [
            'lokasi_preferensis' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
        ]);
    }

    public function updateMahasiswa(ProfileMahasiswaUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = auth()->user();

            if ($request->hasFile('foto_profil_url')) {
                if ($user->foto_profil_url) {
                    Storage::disk('public')->delete($user->foto_profil_url);
                }

                $validated['foto_profil_url'] = $request->file('foto_profil_url')
                    ->store('profile_pictures', 'public');
            }

            $user->update([
                'email' => $validated['email'],
                'foto_profil_url' => $validated['foto_profil_url'] ?? $user->foto_profil_url,
            ]);

            $user->mahasiswa->update([
                'nama' => $validated['nama'],
                'lokasi_preferensi' => $validated['lokasi_preferensi'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diperbarui!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage(),
            ]);
        }
    }

    public function updateStaff(ProfileStaffUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = auth()->user();

            if ($request->hasFile('foto_profil_url')) {
                if ($user->foto_profil_url) {
                    Storage::disk('public')->delete($user->foto_profil_url);
                }

                $validated['foto_profil_url'] = $request->file('foto_profil_url')
                    ->store('profile_pictures', 'public');
            }

            $user->update([
                'email' => $validated['email'],
                'foto_profil_url' => $validated['foto_profil_url'] ?? $user->foto_profil_url,
            ]);

            $user->getCurrentData()->update([
                'nama' => $validated['nama'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diperbarui!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage(),
            ]);
        }

    }

    public function addBidangKeahlianForm()
    {
        if (auth()->user()->role === 'mahasiswa') {
            $bidang_keahlians = BidangKeahlianModel::whereNotIn('bidang_keahlian_id', auth()->user()->mahasiswa->keahlian_mahasiswas->pluck('bidang_keahlian_id'))->get();
        } else if (auth()->user()->role === 'dosen_pembimbing') {
            $bidang_keahlians = BidangKeahlianModel::whereNotIn('bidang_keahlian_id', auth()->user()->dosenPembimbing->keahlian_dosen_pembimbings->pluck('bidang_keahlian_id'))->get();
        }

        return view('profile.modals.add-bidang-keahlian', [
            'bidang_keahlians' => $bidang_keahlians,
        ]);
    }

    public function addBidangKeahlian(ProfileAddBidangKeahlianRequest $request)
    {
        try {
            $validated = $request->validated();
            $bidangKeahlianIds = $validated['bidang_keahlian'];

            if (auth()->user()->role === 'mahasiswa') {
                foreach ($bidangKeahlianIds as $bidangKeahlianId) {
                    KeahlianMahasiswaModel::create([
                        'nim' => auth()->user()->mahasiswa->nim,
                        'bidang_keahlian_id' => $bidangKeahlianId,
                    ]);
                }
            } else if (auth()->user()->role === 'dosen_pembimbing') {
                foreach ($bidangKeahlianIds as $bidangKeahlianId) {
                    KeahlianDosenPembimbingModel::create([
                        'nip' => auth()->user()->dosenPembimbing->nip,
                        'bidang_keahlian_id' => $bidangKeahlianId,
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Bidang keahlian berhasil ditambahkan!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan bidang keahlian: ' . $e->getMessage(),
            ]);
        }
    }

    public function addMinatForm()
    {
        if (auth()->user()->role === 'mahasiswa') {
            $minats = MinatModel::whereNotIn('minat_id', auth()->user()->mahasiswa->minat_mahasiswas->pluck('minat_id'))->get();
        } else if (auth()->user()->role === 'dosen_pembimbing') {
            $minats = MinatModel::whereNotIn('minat_id', auth()->user()->dosenPembimbing->minat_dosen_pembimbings->pluck('minat_id'))->get();
        }

        return view('profile.modals.add-minat', [
            'minats' => $minats,
        ]);
    }

    public function addMinat(ProfileAddMinatRequest $request)
    {
        try {
            $validated = $request->validated();
            $minatIds = $validated['minat'];

            if (auth()->user()->role === 'mahasiswa') {
                foreach ($minatIds as $minatId) {
                    MinatMahasiswaModel::create([
                        'nim' => auth()->user()->mahasiswa->nim,
                        'minat_id' => $minatId,
                    ]);
                }
            } else if (auth()->user()->role === 'dosen_pembimbing') {
                foreach ($minatIds as $minatId) {
                    MinatDosenPembimbingModel::create([
                        'nip' => auth()->user()->dosenPembimbing->nip,
                        'minat_id' => $minatId,
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Minat berhasil ditambahkan!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan minat: ' . $e->getMessage(),
            ]);
        }
    }

    public function deleteBidangKeahlian(string $id)
    {
        if (auth()->user()->role === 'mahasiswa') {
            KeahlianMahasiswaModel::where('bidang_keahlian_id', $id)
                ->where('nim', auth()->user()->mahasiswa->nim)
                ->delete();
        } else if (auth()->user()->role === 'dosen_pembimbing') {
            KeahlianDosenPembimbingModel::where('bidang_keahlian_id', $id)
                ->where('nip', auth()->user()->dosenPembimbing->nip)
                ->delete();
        }
        return redirect()->route('profile.index');
    }

    public function deleteMinat(string $id)
    {
        if (auth()->user()->role === 'mahasiswa') {
            MinatMahasiswaModel::where('minat_id', $id)
                ->where('nim', auth()->user()->mahasiswa->nim)
                ->delete();
        } else if (auth()->user()->role === 'dosen_pembimbing') {
            MinatDosenPembimbingModel::where('minat_id', $id)
                ->where('nip', auth()->user()->dosenPembimbing->nip)
                ->delete();
        }
        return redirect()->route('profile.index');
    }
}
