@extends('layouts.app')
@section('title', 'Ubah Mahasiswa')
@section('page-title', 'Ubah Mahasiswa')
@section('page-subtitle', 'Edit data mahasiswa')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">
        <div class="mb-3 anim"><a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a></div>
        <div class="dark-card anim ad2">
            <div class="card-header"><div class="d-flex align-items-center gap-2"><div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#f59e0b,#f97316);display:flex;align-items:center;justify-content:center;color:white;font-size:.8rem;"><i class="bi bi-pencil-square"></i></div><span>Form Ubah Mahasiswa</span></div></div>
            <div class="card-body p-4">
                <form action="{{ route('mahasiswa.update', $mahasiswa->id_mahasiswa) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required>
                        @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="id_jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_jurusan') is-invalid @enderror" id="id_jurusan" name="id_jurusan" required>
                            <option value="">— Pilih Jurusan —</option>
                            @foreach($jurusan as $j)<option value="{{ $j->id_jurusan }}" {{ old('id_jurusan',$mahasiswa->id_jurusan)==$j->id_jurusan?'selected':'' }}>{{ $j->nama_jurusan }}</option>@endforeach
                        </select>
                        @error('id_jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Simpan</button><a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
