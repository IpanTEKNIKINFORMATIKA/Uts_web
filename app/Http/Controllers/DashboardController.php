<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalJurusan = Jurusan::count();
        $totalMatakuliah = Matakuliah::count();
        $totalSks = Matakuliah::sum('sks');

        $recentMahasiswa = Mahasiswa::with('jurusan')->latest()->take(5)->get();

        // Data untuk chart: distribusi mahasiswa per jurusan
        $jurusanWithCount = Jurusan::withCount(['mahasiswa', 'matakuliah'])->get();

        $chartLabels = $jurusanWithCount->pluck('nama_jurusan')->toArray();
        $chartMahasiswa = $jurusanWithCount->pluck('mahasiswa_count')->toArray();
        $chartMatakuliah = $jurusanWithCount->pluck('matakuliah_count')->toArray();
        $chartAkreditasi = $jurusanWithCount->pluck('akreditasi')->toArray();

        // SKS per jurusan
        $sksPerJurusan = Jurusan::with('matakuliah')->get()->map(function ($j) {
            return [
                'nama' => $j->nama_jurusan,
                'total_sks' => $j->matakuliah->sum('sks'),
            ];
        });

        $chartSksLabels = $sksPerJurusan->pluck('nama')->toArray();
        $chartSksData = $sksPerJurusan->pluck('total_sks')->toArray();

        // Akreditasi summary
        $akreditasiA = $jurusanWithCount->where('akreditasi', 'A')->count();
        $akreditasiB = $jurusanWithCount->where('akreditasi', 'B')->count();
        $akreditasiC = $jurusanWithCount->where('akreditasi', 'C')->count();

        return view('dashboard', compact(
            'totalMahasiswa',
            'totalJurusan',
            'totalMatakuliah',
            'totalSks',
            'recentMahasiswa',
            'jurusanWithCount',
            'chartLabels',
            'chartMahasiswa',
            'chartMatakuliah',
            'chartSksLabels',
            'chartSksData',
            'akreditasiA',
            'akreditasiB',
            'akreditasiC'
        ));
    }
}
