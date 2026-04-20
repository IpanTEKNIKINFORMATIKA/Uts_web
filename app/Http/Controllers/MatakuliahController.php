<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Jurusan;

class MatakuliahController extends Controller
{
    /**
     * Tampilkan semua data matakuliah
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $matakuliah = Matakuliah::with('jurusan')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_matakuliah', 'like', "%{$search}%")
                      ->orWhere('sks', 'like', "%{$search}%")
                      ->orWhereHas('jurusan', function ($q) use ($search) {
                          $q->where('nama_jurusan', 'like', "%{$search}%");
                      });
            })
            ->orderBy('id_matakuliah', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Stats
        $allMk = Matakuliah::with('jurusan')->get();
        $totalMatakuliah = $allMk->count();
        $totalSks = $allMk->sum('sks');
        $avgSks = $totalMatakuliah > 0 ? round($allMk->avg('sks'), 1) : 0;
        $totalJurusan = Jurusan::count();

        return view('matakuliah.data', compact(
            'matakuliah', 'search', 'totalMatakuliah', 'totalSks',
            'avgSks', 'totalJurusan'
        ));
    }

    /**
     * Tampilkan form tambah matakuliah
     */
    public function tambah()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        return view('matakuliah.tambah', compact('jurusan'));
    }

    /**
     * Simpan data matakuliah baru
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ], [
            'nama_matakuliah.required' => 'Nama matakuliah wajib diisi.',
            'sks.required' => 'SKS wajib diisi.',
            'sks.integer' => 'SKS harus berupa angka.',
            'sks.min' => 'SKS minimal 1.',
            'sks.max' => 'SKS maksimal 6.',
            'id_jurusan.required' => 'Jurusan wajib dipilih.',
            'id_jurusan.exists' => 'Jurusan tidak valid.',
        ]);

        Matakuliah::create($request->only(['nama_matakuliah', 'sks', 'id_jurusan']));

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data matakuliah berhasil ditambahkan!');
    }

    /**
     * Tampilkan form ubah matakuliah
     */
    public function ubah($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        return view('matakuliah.ubah', compact('matakuliah', 'jurusan'));
    }

    /**
     * Update data matakuliah
     */
    public function update(Request $request, $id)
    {
        $matakuliah = Matakuliah::findOrFail($id);

        $request->validate([
            'nama_matakuliah' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ], [
            'nama_matakuliah.required' => 'Nama matakuliah wajib diisi.',
            'sks.required' => 'SKS wajib diisi.',
            'id_jurusan.required' => 'Jurusan wajib dipilih.',
        ]);

        $matakuliah->update($request->only(['nama_matakuliah', 'sks', 'id_jurusan']));

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data matakuliah berhasil diupdate!');
    }

    /**
     * Hapus data matakuliah
     */
    public function hapus($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data matakuliah berhasil dihapus!');
    }
}
