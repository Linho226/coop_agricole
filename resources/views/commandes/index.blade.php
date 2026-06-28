@extends('layouts.app')
@section('title', 'Commandes')
@section('page-title', 'Commandes publiques')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-bag-check-fill text-success me-1"></i> Commandes des acheteurs</strong>
        <span class="fw-bold text-success">Total : {{ number_format($total, 0, ',', ' ') }} F</span>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="statut" class="form-select form-select-sm">
                    <option value="">-- Tous les statuts --</option>
                    @foreach(['en_attente' => 'En attente', 'confirmee' => 'Confirmée', 'preparee' => 'Préparée', 'livree' => 'Livrée', 'annulee' => 'Annulée'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('statut') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('commandes.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Téléphone</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commandes as $commande)
                        <tr>
                            <td class="fw-semibold">{{ $commande->reference }}</td>
                            <td>{{ $commande->nom_client }}</td>
                            <td>{{ $commande->telephone }}</td>
                            <td class="fw-bold text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</td>
                            <td><span class="badge bg-{{ $commande->statut_color }}">{{ $commande->statut_label }}</span></td>
                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Aucune commande.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($commandes->hasPages())
        <div class="card-footer">{{ $commandes->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
