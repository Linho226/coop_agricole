@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@push('styles')
<style>
    .dashboard-grid { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 1rem; }
    .metric-card { min-height: 116px; border-left: 4px solid var(--metric-color); }
    .metric-icon {
        width: 42px; height: 42px; border-radius: .6rem;
        display: inline-flex; align-items: center; justify-content: center;
        background: color-mix(in srgb, var(--metric-color) 12%, transparent);
        color: var(--metric-color); font-size: 1.2rem;
    }
    .metric-value { font-size: 1.55rem; line-height: 1.15; font-weight: 800; letter-spacing: 0; }
    .metric-label { color: var(--bs-secondary-color); font-size: .78rem; font-weight: 600; }
    .metric-foot { color: var(--bs-secondary-color); font-size: .74rem; }
    .card-header strong { font-size: .98rem; color: var(--bs-body-color); }
    .span-3 { grid-column: span 3; }
    .span-4 { grid-column: span 4; }
    .span-5 { grid-column: span 5; }
    .span-7 { grid-column: span 7; }
    .span-8 { grid-column: span 8; }
    .span-12 { grid-column: span 12; }
    .chart-box { height: 290px; position: relative; }
    .chart-box-sm { height: 230px; position: relative; }
    .chart-empty {
        height: 100%; display: flex; align-items: center; justify-content: center;
        color: var(--bs-secondary-color); font-size: .9rem;
    }
    .mini-list .list-group-item { padding: .78rem 1rem; }
    .status-dot {
        width: .55rem; height: .55rem; border-radius: 999px; display: inline-block;
        background: currentColor; flex: 0 0 auto;
    }
    .progress-thin { height: .42rem; }
    .soft-panel { background: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color); border-radius: .6rem; padding: .9rem; }
    [data-bs-theme="dark"] .metric-card {
        background: linear-gradient(180deg, #1a2638 0%, #172132 100%);
    }
    [data-bs-theme="dark"] .metric-label,
    [data-bs-theme="dark"] .metric-foot {
        color: #b7c3d7;
    }
    [data-bs-theme="dark"] .soft-panel {
        background: #1d2a3d;
        border-color: #34445d;
    }
    [data-bs-theme="dark"] .progress {
        background-color: #29364a;
    }

    @media (max-width: 1199.98px) {
        .span-3, .span-4 { grid-column: span 6; }
        .span-5, .span-7, .span-8 { grid-column: span 12; }
    }
    @media (max-width: 575.98px) {
        .dashboard-grid { gap: .75rem; }
        .span-3, .span-4, .span-5, .span-7, .span-8, .span-12 { grid-column: span 12; }
        .metric-card { min-height: auto; }
        .chart-box, .chart-box-sm { height: 240px; }
    }
</style>
@endpush

@section('content')
@php
    $formatMoney = fn ($value) => number_format((float) $value, 0, ',', ' ') . ' F';
    $formatNumber = fn ($value) => number_format((float) $value, 0, ',', ' ');
@endphp

<div class="dashboard-grid">
    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:#198754;">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Revenus totaux</div>
                    <div class="metric-value text-success">{{ $formatMoney($stats['revenus']) }}</div>
                    <div class="metric-foot">Cotisations + ventes + commandes</div>
                </div>
                <span class="metric-icon"><i class="bi bi-graph-up-arrow"></i></span>
            </div>
        </div>
    </div>

    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:#dc3545;">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Dépenses</div>
                    <div class="metric-value text-danger">{{ $formatMoney($stats['total_depenses']) }}</div>
                    <div class="metric-foot">Ce mois : {{ $formatMoney($stats['depenses_mois']) }}</div>
                </div>
                <span class="metric-icon"><i class="bi bi-receipt"></i></span>
            </div>
        </div>
    </div>

    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:{{ $stats['solde'] >= 0 ? '#0d6efd' : '#dc3545' }};">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Solde net</div>
                    <div class="metric-value {{ $stats['solde'] >= 0 ? 'text-primary' : 'text-danger' }}">{{ $formatMoney($stats['solde']) }}</div>
                    <div class="metric-foot">Résultat financier global</div>
                </div>
                <span class="metric-icon"><i class="bi bi-bank2"></i></span>
            </div>
        </div>
    </div>

    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:#6f42c1;">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Membres actifs</div>
                    <div class="metric-value" style="color:#6f42c1;">{{ $stats['total_membres'] }}</div>
                    <div class="metric-foot">{{ $stats['membres_inactifs'] }} inactif(s)</div>
                </div>
                <span class="metric-icon"><i class="bi bi-people-fill"></i></span>
            </div>
        </div>
    </div>

    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:#0d6efd;">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Cotisations</div>
                    <div class="metric-value text-primary">{{ $formatMoney($stats['total_cotisations']) }}</div>
                    <div class="metric-foot">Ce mois : {{ $formatMoney($stats['cotisations_mois']) }}</div>
                </div>
                <span class="metric-icon"><i class="bi bi-cash-coin"></i></span>
            </div>
        </div>
    </div>

    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:#fd7e14;">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Ventes internes</div>
                    <div class="metric-value" style="color:#fd7e14;">{{ $formatMoney($stats['total_ventes']) }}</div>
                    <div class="metric-foot">Ce mois : {{ $formatMoney($stats['ventes_mois']) }}</div>
                </div>
                <span class="metric-icon"><i class="bi bi-cart-check-fill"></i></span>
            </div>
        </div>
    </div>

    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:#20c997;">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Commandes clients</div>
                    <div class="metric-value" style="color:#0f8f72;">{{ $formatMoney($stats['total_commandes']) }}</div>
                    <div class="metric-foot">{{ $stats['commandes_en_attente'] }} en attente, {{ $stats['commandes_livrees'] }} livrée(s)</div>
                </div>
                <span class="metric-icon"><i class="bi bi-bag-check-fill"></i></span>
            </div>
        </div>
    </div>

    <div class="span-3">
        <div class="card metric-card h-100" style="--metric-color:#0dcaf0;">
            <div class="card-body d-flex justify-content-between gap-3">
                <div>
                    <div class="metric-label">Stock disponible</div>
                    <div class="metric-value text-info">{{ $formatNumber($stats['stock_total']) }}</div>
                    <div class="metric-foot">{{ $stats['produits_publies'] }} produit(s) publié(s), {{ $stats['stock_faible'] }} stock faible</div>
                </div>
                <span class="metric-icon"><i class="bi bi-box-seam-fill"></i></span>
            </div>
        </div>
    </div>

    <div class="span-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-bar-chart-line-fill text-primary me-1"></i> Évolution financière</strong>
                <span class="text-muted small">6 derniers mois</span>
            </div>
            <div class="card-body">
                <div class="chart-box">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="span-4">
        <div class="card h-100">
            <div class="card-header">
                <strong><i class="bi bi-activity text-success me-1"></i> Situation rapide</strong>
            </div>
            <div class="card-body d-flex flex-column gap-3">
                <div class="soft-panel">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Activités en cours</span>
                        <span class="badge text-bg-primary">{{ $stats['activites_en_cours'] }}</span>
                    </div>
                    <div class="progress progress-thin">
                        <div class="progress-bar" style="width: {{ min(100, $stats['activites_en_cours'] * 20) }}%"></div>
                    </div>
                </div>
                <div class="soft-panel">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Réunions planifiées</span>
                        <span class="badge text-bg-info">{{ $stats['reunions_planifiees'] }}</span>
                    </div>
                    <div class="progress progress-thin">
                        <div class="progress-bar bg-info" style="width: {{ min(100, $stats['reunions_planifiees'] * 20) }}%"></div>
                    </div>
                </div>
                <div class="soft-panel">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Commandes à traiter</span>
                        <span class="badge text-bg-warning">{{ $stats['commandes_en_attente'] }}</span>
                    </div>
                    <div class="progress progress-thin">
                        <div class="progress-bar bg-warning" style="width: {{ min(100, $stats['commandes_en_attente'] * 20) }}%"></div>
                    </div>
                </div>
                <div class="soft-panel">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Produits à surveiller</span>
                        <span class="badge text-bg-danger">{{ $stats['stock_faible'] }}</span>
                    </div>
                    <div class="progress progress-thin">
                        <div class="progress-bar bg-danger" style="width: {{ min(100, $stats['stock_faible'] * 18) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="span-4">
        <div class="card h-100">
            <div class="card-header"><strong><i class="bi bi-basket-fill text-success me-1"></i> Récoltes par produit</strong></div>
            <div class="card-body">
                <div class="chart-box-sm"><canvas id="recoltesChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="span-4">
        <div class="card h-100">
            <div class="card-header"><strong><i class="bi bi-pie-chart-fill text-danger me-1"></i> Dépenses par catégorie</strong></div>
            <div class="card-body">
                <div class="chart-box-sm"><canvas id="depensesChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="span-4">
        <div class="card h-100">
            <div class="card-header"><strong><i class="bi bi-bag-check-fill text-info me-1"></i> Statut des commandes</strong></div>
            <div class="card-body">
                <div class="chart-box-sm"><canvas id="commandesChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="span-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-trophy-fill text-warning me-1"></i> Produits les plus vendus</strong>
                @if(auth()->user()->hasRole(['admin','comptable']))
                    <a href="{{ route('ventes.index') }}" class="btn btn-sm btn-outline-warning">Voir les ventes</a>
                @endif
            </div>
            <div class="card-body">
                <div class="chart-box-sm"><canvas id="ventesProduitsChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="span-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-exclamation-triangle-fill text-danger me-1"></i> Stocks faibles</strong>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('produits.index') }}" class="btn btn-sm btn-outline-danger">Gérer</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush mini-list">
                    @forelse($produits_stock_faible as $produit)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div class="fw-semibold">{{ $produit->nom }}</div>
                                <small class="text-muted">{{ $produit->publie ? 'Publié au catalogue' : 'Non publié' }}</small>
                            </div>
                            <span class="badge text-bg-{{ $produit->stock_disponible <= 0 ? 'danger' : 'warning' }}">
                                {{ $formatNumber($produit->stock_disponible) }} {{ $produit->unite }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-4">Aucun stock faible</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="span-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-people-fill text-success me-1"></i> Derniers membres</strong>
                @if(auth()->user()->hasRole(['admin','secretaire']))
                    <a href="{{ route('membres.index') }}" class="btn btn-sm btn-outline-success">Voir tout</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush mini-list">
                    @forelse($derniers_membres as $m)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <span class="fw-semibold">{{ $m->nom_complet }}</span>
                                <br><small class="text-muted">{{ $m->date_adhesion->format('d/m/Y') }}</small>
                            </div>
                            <span class="badge bg-{{ $m->actif ? 'success' : 'secondary' }}">{{ $m->actif ? 'Actif' : 'Inactif' }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-4">Aucun membre</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="span-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-cash-coin text-primary me-1"></i> Dernières cotisations</strong>
                @if(auth()->user()->hasRole(['admin','comptable']))
                    <a href="{{ route('cotisations.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush mini-list">
                    @forelse($dernieres_cotisations as $c)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <span class="fw-semibold">{{ $c->membre->nom_complet ?? 'N/A' }}</span>
                                <br><small class="text-muted">{{ $c->date_paiement->format('d/m/Y') }}</small>
                            </div>
                            <span class="fw-bold text-primary">{{ $formatMoney($c->montant) }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-4">Aucune cotisation</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="span-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-truck text-info me-1"></i> Dernières commandes</strong>
                @if(auth()->user()->hasRole(['admin','comptable']))
                    <a href="{{ route('commandes.index') }}" class="btn btn-sm btn-outline-info">Voir tout</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush mini-list">
                    @forelse($dernieres_commandes as $commande)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <span class="fw-semibold">{{ $commande->reference }}</span>
                                <br><small class="text-muted">{{ $commande->nom_client }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $formatMoney($commande->montant_total) }}</div>
                                <span class="badge text-bg-{{ $commande->statut_color }}">{{ $commande->statut_label }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-4">Aucune commande</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dashboardCharts = {
        finance: @json($charts['finance']),
        recoltes: @json($charts['recoltes']),
        ventesProduits: @json($charts['ventes_produits']),
        depenses: @json($charts['depenses_categories']),
        commandes: @json($charts['commandes_statuts']),
    };

    const palette = ['#0d6efd', '#198754', '#fd7e14', '#dc3545', '#6f42c1', '#20c997', '#0dcaf0', '#adb5bd'];

    function money(value) {
        return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(value) + ' F';
    }

    function setupCanvas(canvas) {
        const ratio = window.devicePixelRatio || 1;
        const rect = canvas.parentElement.getBoundingClientRect();
        canvas.width = rect.width * ratio;
        canvas.height = rect.height * ratio;
        canvas.style.width = rect.width + 'px';
        canvas.style.height = rect.height + 'px';
        const ctx = canvas.getContext('2d');
        ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
        return { ctx, width: rect.width, height: rect.height };
    }

    function drawEmpty(ctx, width, height, text = 'Aucune donnée') {
        ctx.fillStyle = getComputedStyle(document.body).getPropertyValue('--bs-secondary-color') || '#6c757d';
        ctx.font = '14px system-ui, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(text, width / 2, height / 2);
    }

    function drawGroupedBars(canvasId, labels, datasets) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        const { ctx, width, height } = setupCanvas(canvas);
        ctx.clearRect(0, 0, width, height);

        const max = Math.max(1, ...datasets.flatMap(dataset => dataset.values));
        const padding = { top: 18, right: 18, bottom: 42, left: 52 };
        const plotW = width - padding.left - padding.right;
        const plotH = height - padding.top - padding.bottom;
        const groupW = plotW / labels.length;
        const barW = Math.max(6, (groupW - 18) / datasets.length);

        ctx.strokeStyle = 'rgba(148, 163, 184, .25)';
        ctx.lineWidth = 1;
        ctx.font = '11px system-ui, sans-serif';
        ctx.fillStyle = '#6c757d';
        ctx.textAlign = 'right';
        for (let i = 0; i <= 4; i++) {
            const y = padding.top + plotH - (plotH * i / 4);
            ctx.beginPath();
            ctx.moveTo(padding.left, y);
            ctx.lineTo(width - padding.right, y);
            ctx.stroke();
            ctx.fillText(money(max * i / 4), padding.left - 8, y + 4);
        }

        labels.forEach((label, index) => {
            const x0 = padding.left + index * groupW + 9;
            datasets.forEach((dataset, datasetIndex) => {
                const value = dataset.values[index] || 0;
                const barH = plotH * value / max;
                const x = x0 + datasetIndex * barW;
                const y = padding.top + plotH - barH;
                ctx.fillStyle = dataset.color;
                ctx.fillRect(x, y, barW - 2, barH);
            });
            ctx.fillStyle = '#6c757d';
            ctx.textAlign = 'center';
            ctx.fillText(label, padding.left + index * groupW + groupW / 2, height - 16);
        });

        let legendX = padding.left;
        datasets.forEach(dataset => {
            ctx.fillStyle = dataset.color;
            ctx.fillRect(legendX, 4, 10, 10);
            ctx.fillStyle = '#6c757d';
            ctx.textAlign = 'left';
            ctx.fillText(dataset.label, legendX + 14, 13);
            legendX += ctx.measureText(dataset.label).width + 44;
        });
    }

    function drawHorizontalBars(canvasId, rows, valueFormatter = money) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        const { ctx, width, height } = setupCanvas(canvas);
        ctx.clearRect(0, 0, width, height);

        if (!rows.length) return drawEmpty(ctx, width, height);

        const max = Math.max(1, ...rows.map(row => Number(row.value)));
        const rowH = Math.min(34, (height - 16) / rows.length);
        const labelW = Math.min(120, width * .35);
        const barW = width - labelW - 82;

        ctx.font = '12px system-ui, sans-serif';
        rows.forEach((row, index) => {
            const y = 12 + index * rowH;
            const value = Number(row.value);
            const fillW = Math.max(2, barW * value / max);

            ctx.fillStyle = '#6c757d';
            ctx.textAlign = 'left';
            ctx.fillText(row.label, 0, y + 13);
            ctx.fillStyle = 'rgba(148, 163, 184, .18)';
            ctx.fillRect(labelW, y, barW, 14);
            ctx.fillStyle = palette[index % palette.length];
            ctx.fillRect(labelW, y, fillW, 14);
            ctx.fillStyle = '#6c757d';
            ctx.textAlign = 'right';
            ctx.fillText(valueFormatter(value), width - 2, y + 13);
        });
    }

    function drawDonut(canvasId, rows) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        const { ctx, width, height } = setupCanvas(canvas);
        ctx.clearRect(0, 0, width, height);

        const total = rows.reduce((sum, row) => sum + Number(row.value), 0);
        if (!total) return drawEmpty(ctx, width, height);

        const radius = Math.min(width, height) * .28;
        const cx = width * .34;
        const cy = height * .48;
        let start = -Math.PI / 2;

        rows.forEach((row, index) => {
            const angle = (Number(row.value) / total) * Math.PI * 2;
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.arc(cx, cy, radius, start, start + angle);
            ctx.closePath();
            ctx.fillStyle = palette[index % palette.length];
            ctx.fill();
            start += angle;
        });

        ctx.beginPath();
        ctx.arc(cx, cy, radius * .58, 0, Math.PI * 2);
        ctx.fillStyle = getComputedStyle(document.body).getPropertyValue('--bs-body-bg') || '#fff';
        ctx.fill();
        ctx.fillStyle = '#6c757d';
        ctx.font = 'bold 14px system-ui, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(total.toLocaleString('fr-FR'), cx, cy + 5);

        ctx.font = '12px system-ui, sans-serif';
        rows.forEach((row, index) => {
            const y = 22 + index * 24;
            const x = width * .66;
            ctx.fillStyle = palette[index % palette.length];
            ctx.fillRect(x, y, 10, 10);
            ctx.fillStyle = '#6c757d';
            ctx.textAlign = 'left';
            ctx.fillText(row.label + ' (' + row.value + ')', x + 16, y + 10);
        });
    }

    function renderDashboardCharts() {
        drawGroupedBars('financeChart', dashboardCharts.finance.labels, [
            { label: 'Cotisations', values: dashboardCharts.finance.cotisations, color: '#0d6efd' },
            { label: 'Ventes', values: dashboardCharts.finance.ventes, color: '#198754' },
            { label: 'Dépenses', values: dashboardCharts.finance.depenses, color: '#dc3545' },
        ]);
        drawHorizontalBars('recoltesChart', dashboardCharts.recoltes, value => value.toLocaleString('fr-FR'));
        drawHorizontalBars('ventesProduitsChart', dashboardCharts.ventesProduits);
        drawDonut('depensesChart', dashboardCharts.depenses);
        drawDonut('commandesChart', dashboardCharts.commandes);
    }

    window.addEventListener('load', renderDashboardCharts);
    window.addEventListener('resize', () => {
        clearTimeout(window.dashboardChartResize);
        window.dashboardChartResize = setTimeout(renderDashboardCharts, 150);
    });
    window.addEventListener('coop:theme-change', () => setTimeout(renderDashboardCharts, 40));
</script>
@endpush
