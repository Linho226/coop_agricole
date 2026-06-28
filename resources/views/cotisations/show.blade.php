@extends('layouts.app')
@section('title','Reçu cotisation')
@section('page-title','Détail de cotisation')

@push('styles')
<style>
    .receipt-shell {
        max-width: 920px;
        margin: 0 auto;
    }
    .receipt-panel {
        border: 1px solid var(--bs-border-color);
        border-radius: .7rem;
        background: var(--bs-card-bg, var(--bs-body-bg));
        overflow: hidden;
    }
    .receipt-head {
        background: linear-gradient(135deg, #15213a, #0f766e);
        color: #fff;
        padding: 1.4rem;
    }
    .receipt-line {
        display: grid;
        grid-template-columns: minmax(140px, 1fr) 2fr;
        gap: 1rem;
        padding: .8rem 0;
        border-bottom: 1px solid var(--bs-border-color);
    }
    .receipt-line:last-child { border-bottom: 0; }
    @media print {
        .sidebar, .topbar, .sidebar-overlay, .px-4, .receipt-actions { display: none !important; }
        .main-content { margin-left: 0 !important; }
        .page-content { padding: 0 !important; }
        .receipt-panel { border: 0; }
        body { background: #fff !important; color: #111 !important; }
    }
</style>
@endpush

@section('content')
<div class="receipt-shell">
    <div class="receipt-actions d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('cotisations.edit', $cotisation) }}" class="btn btn-outline-warning">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <button type="button" onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Imprimer le reçu
            </button>
        </div>
    </div>

    <div class="receipt-panel">
        <div class="receipt-head d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <div class="text-uppercase small fw-semibold opacity-75">CoopAgricole</div>
                <h1 class="h3 mb-1">Reçu de cotisation</h1>
                <div class="opacity-75">Gestion des membres et contributions</div>
            </div>
            <div class="text-end">
                <div class="small opacity-75">Référence</div>
                <div class="h5 mb-0">{{ $cotisation->reference_label }}</div>
                <span class="badge {{ $cotisation->statut_badge_class }} mt-2">{{ $cotisation->statut_label }}</span>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card h-100 border-primary">
                        <div class="card-body">
                            <div class="text-muted small">Montant payé</div>
                            <div class="h3 text-primary mb-0">{{ number_format($cotisation->montant, 0, ',', ' ') }} F</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-success">
                        <div class="card-body">
                            <div class="text-muted small">Montant attendu</div>
                            <div class="h3 text-success mb-0">{{ number_format($cotisation->montant_attendu, 0, ',', ' ') }} F</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-warning">
                        <div class="card-body">
                            <div class="text-muted small">Reste à payer</div>
                            <div class="h3 text-warning mb-0">{{ number_format($cotisation->reste_a_payer, 0, ',', ' ') }} F</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="receipt-line">
                <div class="text-muted">Membre</div>
                <div class="fw-semibold">{{ $cotisation->membre->nom_complet ?? 'N/A' }}</div>
            </div>
            <div class="receipt-line">
                <div class="text-muted">Type de cotisation</div>
                <div>{{ $cotisation->type_label }}</div>
            </div>
            <div class="receipt-line">
                <div class="text-muted">Période concernée</div>
                <div>{{ $cotisation->periode_label }}</div>
            </div>
            <div class="receipt-line">
                <div class="text-muted">Date de paiement</div>
                <div>{{ $cotisation->date_paiement->format('d/m/Y') }}</div>
            </div>
            <div class="receipt-line">
                <div class="text-muted">Mode de paiement</div>
                <div>{{ $cotisation->mode_label }}</div>
            </div>
            <div class="receipt-line">
                <div class="text-muted">Enregistré par</div>
                <div>{{ $cotisation->user->name ?? 'Utilisateur non précisé' }}</div>
            </div>
            <div class="receipt-line">
                <div class="text-muted">Observation</div>
                <div>{{ $cotisation->observation ?: 'Aucune observation.' }}</div>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-sm-6">
                    <div class="border-top pt-2 text-muted small">Signature du membre</div>
                </div>
                <div class="col-sm-6">
                    <div class="border-top pt-2 text-muted small">Cachet / signature comptable</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
