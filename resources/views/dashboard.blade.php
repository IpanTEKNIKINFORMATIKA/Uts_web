@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Data Akademik')
@section('page-subtitle', 'Ringkasan data & statistik sistem akademik')

@section('content')
<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card g-emerald anim ad1">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-building"></i></div>
                <span style="font-size:.65rem; background:rgba(255,255,255,.2); padding:.2em .5em; border-radius:5px;">Aktif</span>
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
                <span style="font-size:.65rem; background:rgba(255,255,255,.2); padding:.2em .5em; border-radius:5px;">Terdaftar</span>
            </div>
            <div class="stat-number">{{ $totalMahasiswa }}</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-rose anim ad3">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
                <span style="font-size:.65rem; background:rgba(255,255,255,.2); padding:.2em .5em; border-radius:5px;">{{ $totalSks }} SKS</span>
            </div>
            <div class="stat-number">{{ $totalMatakuliah }}</div>
            <div class="stat-label">Total Mata Kuliah</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card g-violet anim ad4">
            <div class="decor decor-1"></div><div class="decor decor-2"></div>
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="stat-icon"><i class="bi bi-award-fill"></i></div>
                <span style="font-size:.65rem; background:rgba(255,255,255,.2); padding:.2em .5em; border-radius:5px;">
                    A:{{ $akreditasiA }} B:{{ $akreditasiB }}
                </span>
            </div>
            <div class="stat-number">{{ $akreditasiA + $akreditasiB + $akreditasiC }}</div>
            <div class="stat-label">Akreditasi Jurusan</div>
        </div>
    </div>
</div>

<!-- ROW 2: CHARTS -->
<div class="row g-3 mb-4">
    <!-- Donut Chart: Distribusi Mahasiswa -->
    <div class="col-md-4">
        <div class="dark-card anim ad2" style="height:100%;">
            <div class="card-header">
                <span><i class="bi bi-pie-chart-fill me-2" style="color:#8b5cf6;"></i>Distribusi Mahasiswa</span>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height:280px;">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bar Chart: Mahasiswa per Jurusan -->
    <div class="col-md-8">
        <div class="dark-card anim ad3" style="height:100%;">
            <div class="card-header">
                <span><i class="bi bi-bar-chart-fill me-2" style="color:#0ea5e9;"></i>Mahasiswa per Jurusan</span>
                <span class="badge badge-sky">{{ $totalMahasiswa }} Total</span>
            </div>
            <div class="card-body" style="min-height:280px;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ROW 3: More Charts + Table -->
<div class="row g-3 mb-4">
    <!-- SKS per Jurusan -->
    <div class="col-md-4">
        <div class="dark-card anim ad3" style="height:100%;">
            <div class="card-header">
                <span><i class="bi bi-graph-up me-2" style="color:#10b981;"></i>Total SKS / Jurusan</span>
            </div>
            <div class="card-body" style="min-height:260px;">
                <canvas id="sksChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Akreditasi Donut -->
    <div class="col-md-3">
        <div class="dark-card anim ad4" style="height:100%;">
            <div class="card-header">
                <span><i class="bi bi-award me-2" style="color:#f59e0b;"></i>Akreditasi</span>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center" style="min-height:260px;">
                <canvas id="akreditasiChart" style="max-width:180px;"></canvas>
                <div class="d-flex gap-3 mt-3">
                    <div class="text-center">
                        <div style="width:10px;height:10px;border-radius:3px;background:#10b981;margin:0 auto .2rem;"></div>
                        <span style="font-size:.65rem;color:var(--text-muted);">A ({{ $akreditasiA }})</span>
                    </div>
                    <div class="text-center">
                        <div style="width:10px;height:10px;border-radius:3px;background:#0ea5e9;margin:0 auto .2rem;"></div>
                        <span style="font-size:.65rem;color:var(--text-muted);">B ({{ $akreditasiB }})</span>
                    </div>
                    <div class="text-center">
                        <div style="width:10px;height:10px;border-radius:3px;background:#f59e0b;margin:0 auto .2rem;"></div>
                        <span style="font-size:.65rem;color:var(--text-muted);">C ({{ $akreditasiC }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jurusan Ranking -->
    <div class="col-md-5">
        <div class="dark-card anim ad5" style="height:100%;">
            <div class="card-header">
                <span><i class="bi bi-trophy-fill me-2" style="color:#f43f5e;"></i>Ranking Jurusan</span>
            </div>
            <div class="card-body">
                @php
                    $ranked = $jurusanWithCount->sortByDesc('mahasiswa_count');
                    $maxMhs = $ranked->first()->mahasiswa_count ?: 1;
                    $barColors = ['#6366f1','#10b981','#0ea5e9','#f59e0b','#f43f5e'];
                @endphp
                @foreach($ranked as $idx => $j)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span style="font-size:.78rem; font-weight:600; color:rgba(255,255,255,.8);">
                            <span style="color:{{ $barColors[$idx % 5] }}; font-weight:800; margin-right:.3rem;">#{{ $idx + 1 }}</span>
                            {{ $j->nama_jurusan }}
                        </span>
                        <span style="font-size:.72rem; font-weight:700; color:{{ $barColors[$idx % 5] }};">{{ $j->mahasiswa_count }} mhs</span>
                    </div>
                    <div style="height:6px; border-radius:10px; background:rgba(255,255,255,.05);">
                        <div style="height:100%; width:{{ ($j->mahasiswa_count / $maxMhs) * 100 }}%; border-radius:10px; background:{{ $barColors[$idx % 5] }}; transition:width 1s ease;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- ROW 4: Recent Students -->
<div class="row g-3">
    <div class="col-12">
        <div class="dark-card anim ad4">
            <div class="card-header">
                <span><i class="bi bi-clock-history me-2" style="color:#06b6d4;"></i>5 Mahasiswa Terbaru</span>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-sm btn-outline-secondary">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="dark-table">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th>Akreditasi</th>
                                <th>Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMahasiswa as $mhs)
                            <tr>
                                <td><span class="fw-bold" style="color:#818cf8;">{{ $mhs->nim }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @php $avs = ['av-indigo','av-emerald','av-sky','av-amber','av-rose']; @endphp
                                        <div class="row-avatar {{ $avs[$mhs->id_jurusan % 5] }}">{{ strtoupper(substr($mhs->nama,0,2)) }}</div>
                                        <span class="fw-semibold">{{ $mhs->nama }}</span>
                                    </div>
                                </td>
                                <td><span class="badge badge-slate">{{ $mhs->jurusan->nama_jurusan ?? '-' }}</span></td>
                                <td>
                                    @php
                                        $bClass = match($mhs->jurusan->akreditasi ?? '') {
                                            'A' => 'badge-emerald', 'B' => 'badge-sky', default => 'badge-amber'
                                        };
                                    @endphp
                                    <span class="badge {{ $bClass }}">{{ $mhs->jurusan->akreditasi ?? '-' }}</span>
                                </td>
                                <td style="font-size:.75rem; color:var(--text-muted);">{{ $mhs->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5">
                                <div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Belum ada data</h6></div>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
<script>
    const labels = @json($chartLabels);
    const mhsData = @json($chartMahasiswa);
    const mkData = @json($chartMatakuliah);
    const sksLabels = @json($chartSksLabels);
    const sksData = @json($chartSksData);

    Chart.defaults.color = '#64748b';
    Chart.defaults.borderColor = 'rgba(255,255,255,0.04)';
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

    // DONUT CHART
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: mhsData,
                backgroundColor: ['#6366f1','#10b981','#0ea5e9','#f59e0b','#f43f5e','#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            cutout: '65%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 12, usePointStyle: true, pointStyle: 'rectRounded', font: { size: 10, weight: 600 } }
                }
            }
        }
    });

    // BAR CHART
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Mahasiswa',
                    data: mhsData,
                    backgroundColor: 'rgba(99,102,241,0.8)',
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 28,
                },
                {
                    label: 'Mata Kuliah',
                    data: mkData,
                    backgroundColor: 'rgba(14,165,233,0.8)',
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 28,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { font: { size: 10 } } },
                x: { grid: { display: false }, ticks: { font: { size: 9, weight: 600 } } }
            },
            plugins: {
                legend: { labels: { padding: 15, usePointStyle: true, pointStyle: 'rectRounded', font: { size: 10, weight: 600 } } }
            }
        }
    });

    // SKS HORIZONTAL BAR
    new Chart(document.getElementById('sksChart'), {
        type: 'bar',
        data: {
            labels: sksLabels,
            datasets: [{
                label: 'Total SKS',
                data: sksData,
                backgroundColor: ['#10b981','#06b6d4','#6366f1','#f59e0b','#f43f5e'],
                borderRadius: 6,
                borderSkipped: false,
                barThickness: 18,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { font: { size: 9 } } },
                y: { grid: { display: false }, ticks: { font: { size: 9, weight: 600 } } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // AKREDITASI DONUT
    new Chart(document.getElementById('akreditasiChart'), {
        type: 'doughnut',
        data: {
            labels: ['Akreditasi A','Akreditasi B','Akreditasi C'],
            datasets: [{
                data: [{{ $akreditasiA }}, {{ $akreditasiB }}, {{ $akreditasiC }}],
                backgroundColor: ['#10b981','#0ea5e9','#f59e0b'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            cutout: '70%',
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush
