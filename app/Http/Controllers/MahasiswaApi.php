<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaApi extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with('detail_jurusan')->get();

        if (!$mahasiswa) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Detail data mahasiswa',
            'result' => $mahasiswa
        ], 200);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::with('detail_jurusan')->find($id);

        if (!$mahasiswa) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Detail data mahasiswa',
            'result' => $mahasiswa
        ], 200);
    }

    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data mahasiswa Berhasil Ditambahkan',
            'result' => $mahasiswa
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $mahasiswa->update($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data mahasiswa Berhasil Diubah',
            'result' => $mahasiswa
        ], 200);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data mahasiswa Berhasil Dihapus'
        ], 200);
    }
}