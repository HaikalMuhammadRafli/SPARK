<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function admin()
    {
        return view('pages.admin.dashboard');
    }

    public function dosenPembimbing()
    {
        return view('pages.dosen-pembimbing.dashboard');
    }

    public function mahasiswa()
    {
        return view('pages.mahasiswa.dashboard');
    }
}
