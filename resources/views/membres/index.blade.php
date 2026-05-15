@extends('layouts.app')
@section('title', 'Membres')
@section('page-title', 'Gestion des membres')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-people-fill text-success me-1"></i> Liste des membres</strong>
        <a href="{{ route('membres.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Nouveau membre
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Rechercher nom, prénom, téléphone..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="sexe" class="form-select form-select-sm">
                    <option value="">-- Sexe --</option>
                    <option value="M" @selected(request('sexe')=='M')>Masculin</option>
                    <option value="F" @selected(request('sexe')=='F')>Féminin</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('membres.index') }}" class="btn btn-sm btn-outline-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Nom complet</th>
                        <th>Sexe</th>
                        <th>Téléphone</th>
                        <th>Activité</th>
                        <th>Adhésion</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($membres as $membre)
                    <tr>
                        <td>{{ $loop->iteration + ($membres->currentPage()-1)*$membres->perPage() }}</td>
                        <td>
                            @if($membre->photo)
                                <img src="{{ Storage::url($membre->photo) }}" class="rounded-circle" width="36" height="36" style="object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center text-white fw-bold"
                                     style="width:36px;height:36px;font-size:.85rem;">
                                    {{ strtoupper(substr($membre->prenom,0,1).substr($membre->nom,0,1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $membre->nom_complet }}</td>
                        <td>{{ $membre->sexe === 'M' ? 'Masculin' : 'Féminin' }}</td>
                        <td>{{ $membre->telephone ?? '—' }}</td>
                        <td>{{ $membre->activite_agricole ?? '—' }}</td>
                        <td>{{ $membre->date_adhesion->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $membre->actif ? 'success' : 'secondary' }}">
                                {{ $membre->actif ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('membres.show', $membre) }}" class="btn btn-sm btn-outline-info" title="Détail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('membres.edit', $membre) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('membres.destroy', $membre) }}" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce membre ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Aucun membre trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($membres->hasPages())
    <div class="card-footer">
        {{ $membres->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Lazy load storage URLs
document.addEventListener('DOMContentLoaded', function() {});
</script>
@endpush
