@extends('layouts.app')
@section('title', 'Ubah Jurusan')
@section('page-title', 'Ubah Jurusan')
@section('page-subtitle', 'Edit data program studi')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">
        <div class="mb-3 anim"><a href="{{ route('jurusan.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a></div>
        <div class="dark-card anim ad2">
            <div class="card-header"><div class="d-flex align-items-center gap-2"><div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#f59e0b,#f97316);display:flex;align-items:center;justify-content:center;color:white;font-size:.8rem;"><i class="bi bi-pencil-square"></i></div><span>Form Ubah Jurusan</span></div></div>
            <div class="card-body p-4">
                <form action="{{ route('jurusan.update', $jurusan->id_jurusan) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="nama_jurusan" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required>
                        @error('nama_jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="akreditasi" class="form-label">Akreditasi</label>
                        <select class="form-select @error('akreditasi') is-invalid @enderror" id="akreditasi" name="akreditasi">
                            <option value="">— Pilih Akreditasi —</option>
                            <option value="A" {{ old('akreditasi',$jurusan->akreditasi)=='A'?'selected':'' }}>A — Unggul</option>
                            <option value="B" {{ old('akreditasi',$jurusan->akreditasi)=='B'?'selected':'' }}>B — Baik Sekali</option>
                            <option value="C" {{ old('akreditasi',$jurusan->akreditasi)=='C'?'selected':'' }}>C — Baik</option>
                        </select>
                        @error('akreditasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Simpan</button><a href="{{ route('jurusan.index') }}" class="btn btn-outline-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
