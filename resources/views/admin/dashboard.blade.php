@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card p-4">
                <div class="text-muted">Articles publies</div>
                <div class="h3 mb-1">{{ $publishedArticles }}</div>
                <div class="badge-soft">+{{ $growth }}% ce mois</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card p-4">
                <div class="text-muted">Utilisateurs actifs</div>
                <div class="h3 mb-1">{{ $activeUsers }}</div>
                <div class="text-muted small">Communautes engagees</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card p-4">
                <div class="text-muted">Commentaires</div>
                <div class="h3 mb-1">{{ $comments }}</div>
                <div class="text-muted small">Flux de moderation</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card p-4">
                <div class="text-muted">Vues totales</div>
                <div class="h3 mb-1">{{ number_format($totalViews) }}</div>
                <div class="text-muted small">Audiences cumulees</div>
            </div>
        </div>
    </div>

    <div class="stat-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Performance mensuelle</h5>
            <span class="badge-soft">Derniers 12 mois</span>
        </div>
        <canvas id="monthlyChart" height="120"></canvas>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const chartData = @json($monthlyStats);
        const labels = chartData.map(item => item.label);
        const values = chartData.map(item => item.value);

        const ctx = document.getElementById('monthlyChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Vues',
                    data: values,
                    backgroundColor: 'rgba(255, 122, 26, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endpush
