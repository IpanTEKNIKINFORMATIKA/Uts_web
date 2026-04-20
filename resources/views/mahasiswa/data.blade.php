@extends('layouts.app')

@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa')
@section('page-subtitle', 'Kelola data mahasiswa terdaftar')

@section('content')
<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card g-amber anim ad1">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="stat-number">{{ $totalMahasiswa }}</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-emerald anim ad2">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-building"></i></div>
            </div>
            <div class="stat-number">{{ $totalJurusan }}</div>
            <div class="stat-label">Jurusan Tersedia</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-violet anim ad3">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="stat-number">{{ $totalJurusan > 0 ? round($totalMahasiswa / $totalJurusan) : 0 }}</div>
            <div class="stat-label">Rata-rata / Jurusan</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-rose anim ad4">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-person-plus-fill"></i></div>
            </div>
            <div class="stat-number">{{ $mahasiswa->count() }}</div>
            <div class="stat-label">Di Halaman Ini</div>
        </div>
    </div>
</div>

<!-- MAIN TABLE -->
<div class="dark-card anim ad3">
    <div class="card-header">
        <span><i class="bi bi-table me-2" style="color:#06b6d4;"></i>Daftar Mahasiswa</span>
        <div class="d-flex gap-2 align-items-center ms-auto">
            <form action="{{ route('mahasiswa.index') }}" method="GET" style="width:250px;">
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari NIM / nama..." value="{{ $search }}">
                </div>
            </form>
            <a href="{{ route('mahasiswa.tambah') }}" class="btn btn-sm btn-primary">
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
                        <th width="110">NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jurusan</th>
                        <th width="120">Tgl. Daftar</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswa as $i => $mhs)
                    <tr>
                        <td style="color:var(--text-dim); font-weight:600;">{{ $mahasiswa->firstItem() + $i }}</td>
                        <td><span class="fw-bold" style="color:#818cf8;">{{ $mhs->nim }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @php $avs = ['av-indigo','av-emerald','av-sky','av-amber','av-rose']; @endphp
                                <div class="row-avatar {{ $avs[$mhs->id_jurusan % 5] }}">{{ strtoupper(substr($mhs->nama,0,2)) }}</div>
                                <span class="fw-bold" style="color:var(--text-white);">{{ $mhs->nama }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-slate">{{ $mhs->jurusan->nama_jurusan ?? '-' }}</span></td>
                        <td style="font-size:.75rem; color:var(--text-muted);">{{ $mhs->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('mahasiswa.ubah', $mhs->id_mahasiswa) }}" class="btn btn-warning btn-icon" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('mahasiswa.hapus', $mhs->id_mahasiswa) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus {{ $mhs->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon" title="Hapus"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">
                        <div class="empty-state"><div class="empty-icon"><i class="bi bi-people"></i></div><h6>Belum ada data</h6><p>Klik "Tambah" untuk menambahkan.</p></div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($mahasiswa->hasPages())
    <div class="card-body border-top d-flex justify-content-end pt-3 pb-2" style="border-color:var(--border)!important;">
        {{ $mahasiswa->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
