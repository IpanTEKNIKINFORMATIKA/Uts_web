@extends('layouts.app')

@section('title', 'Data Jurusan')
@section('page-title', 'Data Jurusan')
@section('page-subtitle', 'Kelola data program studi')

@section('content')
<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card g-emerald anim ad1">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-building"></i></div>
            </div>
            <div class="stat-number">{{ $totalJurusan }}</div>
            <div class="stat-label">Total Jurusan</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-amber anim ad2">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="stat-number">{{ $totalMahasiswa }}</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-violet anim ad3">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
            </div>
            <div class="stat-number">{{ $totalMatakuliah }}</div>
            <div class="stat-label">Total Mata Kuliah</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-rose anim ad4">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-award-fill"></i></div>
            </div>
            <div class="stat-number">{{ $akreditasiA }}</div>
            <div class="stat-label">Akreditasi A</div>
        </div>
    </div>
</div>

<!-- MAIN TABLE -->
<div class="dark-card anim ad3">
    <div class="card-header">
        <span><i class="bi bi-table me-2" style="color:#10b981;"></i>Daftar Program Studi</span>
        <div class="d-flex gap-2 align-items-center ms-auto">
            <form action="{{ route('jurusan.index') }}" method="GET" style="width:250px;">
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari jurusan..." value="{{ $search }}">
                </div>
            </form>
            <a href="{{ route('jurusan.tambah') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="dark-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Jurusan</th>
                        <th width="110">Akreditasi</th>
                        <th width="120">Mahasiswa</th>
                        <th width="120">Mata Kuliah</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusan as $i => $j)
                    <tr>
                        <td style="color:var(--text-dim); font-weight:600;">{{ $jurusan->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @php $avs = ['av-indigo','av-emerald','av-sky','av-amber','av-rose']; @endphp
                                <div class="row-avatar {{ $avs[$i % 5] }}">{{ strtoupper(substr($j->nama_jurusan,0,2)) }}</div>
                                <span class="fw-bold" style="color:var(--text-white);">{{ $j->nama_jurusan }}</span>
                            </div>
                        </td>
                        <td>
                            @php $bClass = match($j->akreditasi) { 'A'=>'badge-emerald','B'=>'badge-sky',default=>'badge-amber' }; @endphp
                            <span class="badge {{ $bClass }}">{{ $j->akreditasi ?? '-' }}</span>
                        </td>
                        <td>
                            <span style="font-size:.78rem; color:rgba(255,255,255,.6);">
                                <i class="bi bi-people me-1" style="color:#10b981;"></i>{{ $j->mahasiswa_count }} orang
                            </span>
                        </td>
                        <td>
                            <span style="font-size:.78rem; color:rgba(255,255,255,.6);">
                                <i class="bi bi-journal me-1" style="color:#0ea5e9;"></i>{{ $j->matakuliah_count }} matkul
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('jurusan.ubah', $j->id_jurusan) }}" class="btn btn-warning btn-icon" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('jurusan.hapus', $j->id_jurusan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus {{ $j->nama_jurusan }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon" title="Hapus"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">
                        <div class="empty-state"><div class="empty-icon"><i class="bi bi-building"></i></div><h6>Belum ada data jurusan</h6><p>Klik "Tambah" untuk menambahkan.</p></div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($jurusan->hasPages())
    <div class="card-body border-top d-flex justify-content-end pt-3 pb-2" style="border-color:var(--border)!important;">
        {{ $jurusan->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
