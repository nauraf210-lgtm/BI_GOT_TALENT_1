<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Halaman Utama Admin
    public function index() 
    {
        return view('admin.dashboard'); 
    }

    // Halaman Kelola Lomba
    public function kelolaLomba() 
    {
        $lombas = Lomba::all();
        return view('admin.kelola_lomba', compact('lombas'));
    }

    // Halaman Kelola Siswa
    public function kelolaSiswa() 
    {
        $siswas = User::where('role', 'siswa')->get();
        return view('admin.kelola_siswa', compact('siswas'));
    }

    // Halaman Kelola Status Pendaftaran
    public function kelolaStatus() 
    {
        $pendaftarans = Pendaftaran::with(['user', 'lomba'])->get();
        return view('admin.kelola_status', compact('pendaftarans'));
    }

    // Process CRUD Lomba
    public function storeLomba(Request $request)
    {
        Lomba::create($request->all());
        return back()->with('success', 'Mata Lomba berhasil ditambahkan!');
    }

    public function editLomba($id)
    {
        $lomba = Lomba::findOrFail($id);
        return view('admin.edit_lomba', compact('lomba'));
    }

    public function updateLomba(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);
        $lomba->update($request->all());
        return redirect()->route('admin.lomba')->with('success', 'Mata lomba berhasil diperbarui!');
    }

    public function destroyLomba($id)
    {
        Lomba::findOrFail($id)->delete();
        return back()->with('success', 'Mata lomba berhasil dihapus!');
    }

    // Process Update Status Pendaftaran
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);
        return back()->with('success', 'Status pendaftaran berhasil diubah!');
    }

    // Process CRUD Siswa
    public function storeSiswa(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa'
        ]);
        return back()->with('success', 'Akun siswa berhasil dibuat!');
    }

    public function editSiswa($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.edit_siswa', compact('siswa'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = User::findOrFail($id);
        $siswa->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if($request->filled('password')) {
            $siswa->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroySiswa($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Akun siswa berhasil dihapus!');
    }
}