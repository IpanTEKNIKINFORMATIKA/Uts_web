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

    // PRINT CSV
    public function exportCsv()
    {
        $fileName = 'jurusan.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'Nama Jurusan',
                'Akreditasi',
                'Jumlah Mahasiswa',
                'Jumlah Mata Kuliah'
            ], ';');

            $jurusan = Jurusan::withCount(['mahasiswa', 'matakuliah'])->get();

            foreach ($jurusan as $item) {
                fputcsv($file, [
                    $item->id_jurusan,
                    $item->nama_jurusan,
                    $item->akreditasi ?? '-',
                    $item->mahasiswa_count,
                    $item->matakuliah_count,
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print()
    {
        $jurusan = Jurusan::withCount(['mahasiswa', 'matakuliah'])->get();

        return view('jurusan.print', compact('jurusan'));
    }

    public function exportExcel()
    {
        $jurusan = Jurusan::withCount(['mahasiswa', 'matakuliah'])->get();

        return response()
            ->view('jurusan.excel', compact('jurusan'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=jurusan.xls');
    }
}
