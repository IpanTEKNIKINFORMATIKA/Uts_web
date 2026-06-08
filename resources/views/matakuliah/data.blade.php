@extends('layouts.app')

@section('title', 'Data Mata Kuliah')
@section('page-title', 'Data Mata Kuliah')
@section('page-subtitle', 'Kelola data mata kuliah')

@section('content')
<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card g-violet anim ad1">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
            </div>
            <div class="stat-number">{{ $totalMatakuliah }}</div>
            <div class="stat-label">Total Mata Kuliah</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-emerald anim ad2">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-stack"></i></div>
            </div>
            <div class="stat-number">{{ $totalSks }}</div>
            <div class="stat-label">Total SKS</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-amber anim ad3">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-calculator"></i></div>
            </div>
            <div class="stat-number">{{ $avgSks }}</div>
            <div class="stat-label">Rata-rata SKS</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-rose anim ad4">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-building"></i></div>
            </div>
            <div class="stat-number">{{ $totalJurusan }}</div>
            <div class="stat-label">Jurusan Terkait</div>
        </div>
    </div>
</div>

<!-- MAIN TABLE -->
<div class="dark-card anim ad3">
    <div class="card-header">
        <span><i class="bi bi-table me-2" style="color:#f59e0b;"></i>Daftar Mata Kuliah</span>
        <div class="d-flex gap-2 align-items-center ms-auto">
            <form action="{{ route('matakuliah.index') }}" method="GET" style="width:250px;">
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari matakuliah..." value="{{ $search }}">
                </div>
            </form>
            <a href="{{ route('matakuliah.tambah') }}" class="btn btn-sm btn-primary">
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
                        <th>Nama Mata Kuliah</th>
                        <th width="90">SKS</th>
                        <th>Jurusan</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matakuliah as $i => $mk)
                    <tr>
                        <td style="color:var(--text-dim); font-weight:600;">{{ $matakuliah->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @php $avs = ['av-sky','av-indigo','av-emerald','av-amber','av-rose']; @endphp
                                <div class="row-avatar {{ $avs[$mk->id_jurusan % 5] }}">{{ strtoupper(substr($mk->nama_matakuliah,0,2)) }}</div>
                                <span class="fw-bold" style="color:var(--text-white);">{{ $mk->nama_matakuliah }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-violet">{{ $mk->sks }} SKS</span></td>
                        <td><span class="badge badge-slate">{{ $mk->jurusan->nama_jurusan ?? '-' }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('matakuliah.ubah', $mk->id_matakuliah) }}" class="btn btn-warning btn-icon" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('matakuliah.hapus', $mk->id_matakuliah) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus {{ $mk->nama_matakuliah }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon" title="Hapus"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">
                        <div class="empty-state"><div class="empty-icon"><i class="bi bi-journal-bookmark"></i></div><h6>Belum ada data</h6><p>Klik "Tambah" untuk menambahkan.</p></div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('matakuliah.print') }}" target="_blank">
        Export PDF
    </a>
    <a href="{{ url('/matakuliah/export-csv') }}" target="_blank">
        Export Excel
    </a>
    @if($matakuliah->hasPages())
    <div class="card-body border-top d-flex justify-content-end pt-3 pb-2 pagination-container" style="border-color:var(--border)!important;">
        {{ $matakuliah->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const form = searchInput?.closest('form');
    const tableBody = document.querySelector('.dark-table tbody');
    const card = document.querySelector('.dark-card');

    if (!searchInput) return;

    let debounceTimer;
    
    // Function to fetch and update table
    const performSearch = (query) => {
        const url = new URL(window.location.href);
        if (query) {
            url.searchParams.set('search', query);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.delete('page'); // Reset to page 1 on new search

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // 1. Update Table Body
                const newTableBody = doc.querySelector('.dark-table tbody');
                if (tableBody && newTableBody) {
                    tableBody.innerHTML = newTableBody.innerHTML;
                }
                
                // 2. Update Pagination
                const newPagination = doc.querySelector('.pagination-container');
                const oldPagination = document.querySelector('.pagination-container');
                
                if (oldPagination) {
                    if (newPagination) {
                        oldPagination.outerHTML = newPagination.outerHTML;
                    } else {
                        oldPagination.remove();
                    }
                } else if (newPagination) {
                    card?.appendChild(newPagination);
                }

                // 3. Update URL in browser history
                window.history.pushState({ path: url.toString() }, '', url.toString());

                // 4. Re-bind click events for new pagination links
                bindPaginationLinks();
            })
            .catch(err => console.error('Error searching:', err));
    };

    // Prevent default form submit on Enter
    form?.addEventListener('submit', (e) => {
        e.preventDefault();
        performSearch(searchInput.value.trim());
    });

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = searchInput.value.trim();
        if (query === '') {
            performSearch('');
        } else {
            debounceTimer = setTimeout(() => {
                performSearch(query);
            }, 300);
        }
    });

    // Helper to handle pagination links via AJAX
    function bindPaginationLinks() {
        const links = document.querySelectorAll('.pagination a.page-link');
        links.forEach(link => {
            const newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);
            
            newLink.addEventListener('click', function(e) {
                e.preventDefault();
                const pageUrl = this.getAttribute('href');
                if (!pageUrl) return;

                fetch(pageUrl)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newTableBody = doc.querySelector('.dark-table tbody');
                        if (tableBody && newTableBody) {
                            tableBody.innerHTML = newTableBody.innerHTML;
                        }
                        
                        const newPagination = doc.querySelector('.pagination-container');
                        const oldPagination = document.querySelector('.pagination-container');
                        
                        if (oldPagination) {
                            if (newPagination) {
                                oldPagination.outerHTML = newPagination.outerHTML;
                            } else {
                                oldPagination.remove();
                            }
                        } else if (newPagination) {
                            card?.appendChild(newPagination);
                        }

                        window.history.pushState({ path: pageUrl }, '', pageUrl);
                        bindPaginationLinks(); // Re-bind for new pagination
                        
                        document.querySelector('.dark-card')?.scrollIntoView({ behavior: 'smooth' });
                    });
            });
        });
    }

    bindPaginationLinks();
});
</script>
@endpush
@endsection
