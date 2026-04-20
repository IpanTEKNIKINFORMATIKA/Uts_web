<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Jurusan;

class MahasiswaController extends Controller
{
    /**
     * Tampilkan semua data mahasiswa
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mahasiswa = Mahasiswa::with('jurusan')
            ->when($search, function ($query) use ($search) {
                $query->where('nim', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhereHas('jurusan', function ($q) use ($search) {
                          $q->where('nama_jurusan', 'like', "%{$search}%");
                      });
            })
            ->orderBy('id_mahasiswa', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Stats
        $totalMahasiswa = Mahasiswa::count();
        $totalJurusan = Jurusan::count();

        return view('mahasiswa.data', compact(
            'mahasiswa', 'search', 'totalMahasiswa', 'totalJurusan'
        ));
    }

    /**
     * Tampilkan form tambah mahasiswa
     */
    public function tambah()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        return view('mahasiswa.tambah', compact('jurusan'));
    }

    /**
     * Simpan data mahasiswa baru
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama mahasiswa wajib diisi.',
            'id_jurusan.required' => 'Jurusan wajib dipilih.',
            'id_jurusan.exists' => 'Jurusan tidak valid.',
        ]);

        Mahasiswa::create($request->only(['nim', 'nama', 'id_jurusan']));

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    /**
     * Tampilkan form ubah mahasiswa
     */
    public function ubah($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        return view('mahasiswa.ubah', compact('mahasiswa', 'jurusan'));
    }

    /**
     * Update data mahasiswa
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $id . ',id_mahasiswa',
            'nama' => 'required|string|max:255',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama mahasiswa wajib diisi.',
            'id_jurusan.required' => 'Jurusan wajib dipilih.',
        ]);

        $mahasiswa->update($request->only(['nim', 'nama', 'id_jurusan']));

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diupdate!');
    }

    /**
     * Hapus data mahasiswa
     */
    public function hapus($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}
