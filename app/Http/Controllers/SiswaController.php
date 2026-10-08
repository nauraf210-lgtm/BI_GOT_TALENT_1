<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $lombas = Lomba::all();
        $riwayat = Pendaftaran::with('lomba')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.dashboard', compact('lombas', 'riwayat'));
    }

    public function daftarLomba(Request $request)
    {
        $request->validate([
            'lomba_id' => 'required',
            'kelas' => 'required|string|max:50',
            'no_wa' => 'required|string|max:20',
        ]);

        $sudahDaftar = Pendaftaran::where('user_id', Auth::id())
                                  ->where('lomba_id', $request->lomba_id)
                                  ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Gagal: Anda sudah terdaftar di mata lomba ini.');
        }

        Pendaftaran::create([
            'user_id' => Auth::id(),
            'lomba_id' => $request->lomba_id,
            'kelas' => $request->kelas,
            'no_wa' => $request->no_wa,
            'status' => 'Dokumen dalam Tinjauan'
        ]);

        return back()->with('success', 'Berhasil mendaftar! Silakan pantau status Anda di bawah.');
    }
}