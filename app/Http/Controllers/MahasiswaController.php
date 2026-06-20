<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    // 1. Menampilkan Halaman Utama (Dashboard Tampilan Baru)
    public function index()
    {
        // Mengambil semua data mahasiswa beserta rekap absennya hari ini
        $mahasiswa = DB::table('daftar_mahasiswas')
            ->leftJoin('absensis', function($join) {
                $join->on('daftar_mahasiswas.nim', '=', 'absensis.nim')
                     ->whereDate('absensis.created_at', Carbon::today()->toDateString());
            })
            ->select(
                'daftar_mahasiswas.id as mahasiswa_id', 
                'daftar_mahasiswas.nim', 
                'daftar_mahasiswas.nama', 
                'absensis.id as absensi_id',      
                'absensis.waktu_absen', 
                'absensis.status'
            )
            ->get();

        // Hitung statistik rekap di bagian bawah card widget
        $totalMahasiswa = $mahasiswa->count();
        $totalHadir = $mahasiswa->where('status', 'Hadir')->count();
        $totalIzin = $mahasiswa->where('status', 'Izin')->count();
        $totalAlpa = $mahasiswa->where('status', 'Alpa')->count();

        return view('index', compact('mahasiswa', 'totalMahasiswa', 'totalHadir', 'totalIzin', 'totalAlpa')); 
    }

    // 2. Fitur Rekap Absensi Baru
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'status' => 'required|in:Hadir,Izin,Alpa'
        ]);

        $mahasiswa = DB::table('daftar_mahasiswas')->where('nim', $request->nim)->first();

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa tidak ditemukan!');
        }

        $hariIni = Carbon::today()->toDateString();

        // Cek apakah mahasiswa ini sudah absen hari ini
        $sudahAbsen = DB::table('absensis')
            ->where('nim', $request->nim)
            ->whereDate('created_at', $hariIni)
            ->exists();

        if ($sudahAbsen) {
            // Jika sudah ada, kita update statusnya
            DB::table('absensis')
                ->where('nim', $request->nim)
                ->whereDate('created_at', $hariIni)
                ->update([
                    'status' => $request->status,
                    'waktu_absen' => Carbon::now()->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB',
                    'updated_at' => Carbon::now()
                ]);
            return redirect()->route('mahasiswa.index')->with('success', 'Status absensi berhasil diperbarui!');
        }

        // Jika belum absen, insert data baru
        DB::table('absensis')->insert([
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'waktu_absen' => Carbon::now()->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB',
            'status' => $request->status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Absensi berhasil dicatat!');
    }

    // 3. Menyimpan data pendaftaran mahasiswa baru (Modal Form terintegrasi)
    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:daftar_mahasiswas,nim', 
            'nama' => 'required',
        ]);

        DB::table('daftar_mahasiswas')->insert([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa baru berhasil didaftarkan!');
    }

    // 4. Proses Update Biodata Nama/NIM Mahasiswa
    public function updateMahasiswa(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|unique:daftar_mahasiswas,nim,' . $id,
            'nama' => 'required',
        ]);

        $mahasiswaLama = DB::table('daftar_mahasiswas')->where('id', $id)->first();

        if ($mahasiswaLama) {
            DB::table('daftar_mahasiswas')->where('id', $id)->update([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'updated_at' => Carbon::now()
            ]);

            DB::table('absensis')->where('nim', $mahasiswaLama->nim)->update([
                'nim' => $request->nim,
                'nama' => $request->nama
            ]);
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Data biodata mahasiswa berhasil diperbarui!');
    }

    // 5. Fitur Hapus Mahasiswa Permanen dari Sistem
    public function destroyMahasiswa($id)
    {
        $mahasiswa = DB::table('daftar_mahasiswas')->where('id', $id)->first();

        if ($mahasiswa) {
            DB::table('absensis')->where('nim', $mahasiswa->nim)->delete();
            DB::table('daftar_mahasiswas')->where('id', $id)->delete();
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus dari sistem!');
    }
}