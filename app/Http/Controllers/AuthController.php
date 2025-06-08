<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\AdminModel;
use App\Models\BidangKeahlianModel;
use App\Models\DosenPembimbingModel;
use App\Models\KompetensiModel;
use App\Models\MahasiswaModel;
use App\Models\MinatModel;
use App\Models\ProgramStudiModel;
use App\Models\UserModel;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $user = $this->findUserByIdentifier($credentials['identifier']);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Akun tidak ditemukan!',
                ]);
            }

            if (Auth::attempt(['user_id' => $user->user_id, 'password' => $credentials['password']])) {
                $token = $user->createToken('api-token')->plainTextToken;
                $request->session()->regenerate();

                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => $this->getRoute($user->role),
                    'token' => $token,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'NIM/NIP atau password salah!',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Login gagal!, ' . $e->getMessage(),
            ]);
        }
    }

    private function findUserByIdentifier($identifier)
    {
        $mahasiswa = MahasiswaModel::where('nim', $identifier)->first();
        if ($mahasiswa) {
            return $mahasiswa->user;
        }

        $dosen_pembimbing = DosenPembimbingModel::where('nip', $identifier)->first();
        if ($dosen_pembimbing) {
            return $dosen_pembimbing->user;
        }
        $admin = AdminModel::where('nip', $identifier)->first();
        if ($admin) {
            return $admin->user;
        }

        return null;
    }

    private function getRoute($role)
    {
        switch ($role) {
            case 'admin':
                return route('admin.dashboard');
            case 'dosen_pembimbing':
                return route('dosen-pembimbing.dashboard');
            case 'mahasiswa':
                return route('mahasiswa.dashboard');
            default:
                return route('login');
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register', [
            'program_studis' => ProgramStudiModel::all(),
            'bidang_keahlians' => BidangKeahlianModel::all(),
            'minats' => MinatModel::all(),
            'lokasi_preferensis' => [
                'Kota' => 'Kota',
                'Provinsi' => 'Provinsi',
                'Nasional' => 'Nasional',
                'Internasional' => 'Internasional',
            ],
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $userData = [
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'mahasiswa',
                'status_akun' => 'aktif',
                'last_login_at' => now(),
            ];

            $user = UserModel::create($userData);

            $mahasiswaData = [
                'nim' => $validated['nim'],
                'nama' => $validated['nama'],
                'program_studi_id' => $validated['program_studi'],
                'lokasi_preferensi' => $validated['lokasi_preferensi'],
                'user_id' => $user->user_id,
            ];

            $mahasiswa = MahasiswaModel::create($mahasiswaData);

            $mahasiswa->minats()->attach($validated['minat']);
            $mahasiswa->bidang_keahlians()->attach($validated['bidang_keahlian']);

            if ($user && $mahasiswa) {
                DB::commit();
                Auth::login($user);
                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi berhasil!',
                    'redirect' => route('mahasiswa.dashboard'),
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Registrasi gagal!',
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Registrasi gagal!, ' . $e->getMessage(),
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
