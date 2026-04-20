<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    /**
     * Tampilkan semua data jurusan
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jurusan = Jurusan::withCount(['mahasiswa', 'matakuliah'])
            ->when($search, function ($query) use ($search) {
                $query->where('nama_jurusan', 'like', "%{$search}%")
                      ->orWhere('akreditasi', 'like', "%{$search}%");
            })
            ->orderBy('id_jurusan', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Stats for dashboard-style header
        $allJurusan = Jurusan::withCount(['mahasiswa', 'matakuliah'])->get();
        $totalJurusan = $allJurusan->count();
        $totalMahasiswa = $allJurusan->sum('mahasiswa_count');
        $totalMatakuliah = $allJurusan->sum('matakuliah_count');
        $akreditasiA = $allJurusan->where('akreditasi', 'A')->count();

        return view('jurusan.data', compact(
            'jurusan', 'search', 'totalJurusan', 'totalMahasiswa',
            'totalMatakuliah', 'akreditasiA'
        ));
    }

    /**
     * Tampilkan form tambah jurusan
     */
    public function tambah()
    {
        return view('jurusan.tambah');
    }

    /**
     * Simpan data jurusan baru
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan,nama_jurusan',
            'akreditasi' => 'nullable|string|max:10',
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'nama_jurusan.unique' => 'Nama jurusan sudah ada.',
            'nama_jurusan.max' => 'Nama jurusan maksimal 255 karakter.',
        ]);

        Jurusan::create($request->only(['nama_jurusan', 'akreditasi']));

        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil ditambahkan!');
    }

    /**
     * Tampilkan form ubah jurusan
     */
    public function ubah($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('jurusan.ubah', compact('jurusan'));
    }

    /**
     * Update data jurusan
     */
    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan,nama_jurusan,' . $id . ',id_jurusan',
            'akreditasi' => 'nullable|string|max:10',
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'nama_jurusan.unique' => 'Nama jurusan sudah ada.',
        ]);

        $jurusan->update($request->only(['nama_jurusan', 'akreditasi']));

        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil diupdate!');
    }

    /**
     * Hapus data jurusan
     */
    public function hapus($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil dihapus!');
    }
}
