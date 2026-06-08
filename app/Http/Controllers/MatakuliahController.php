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

    public function exportCsv()
    {
        $fileName = 'matakuliah.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'Nama Mata Kuliah',
                'SKS',
                'Jurusan'
            ], ';');

            $matakuliah = Matakuliah::with('jurusan')->get();

            foreach ($matakuliah as $item) {
                fputcsv($file, [
                    $item->id_matakuliah,
                    $item->nama_matakuliah,
                    $item->sks,
                    $item->jurusan->nama_jurusan ?? '-',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print()
    {
        $matakuliah = Matakuliah::with('jurusan')->get();

        return view('matakuliah.print', compact('matakuliah'));
    }

    public function exportExcel()
    {
        $matakuliah = Matakuliah::with('jurusan')->get();

        return response()
            ->view('matakuliah.excel', compact('matakuliah'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=matakuliah.xls');
    }
}
