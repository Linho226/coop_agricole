@extends('layouts.app')
@section('title','Activités')
@section('page-title','Activités agricoles')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-clipboard2-check-fill text-info me-1"></i> Activités agricoles</strong>
        <a href="{{ route('activites.create') }}" class="btn btn-info btn-sm text-white">
            <i class="bi bi-plus-lg"></i> Nouvelle activité
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Type d'activité..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="statut" class="form-select form-select-sm">
                    <option value="">-- Tous statuts --</option>
                    <option value="planifie" @selected(request('statut')=='planifie')>Planifié</option>
                    <option value="en_cours" @selected(request('statut')=='en_cours')>En cours</option>
                    <option value="termine" @selected(request('statut')=='termine')>Terminé</option>
                    <option value="annule" @selected(request('statut')=='annule')>Annulé</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('activites.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Type d'activité</th><th>Responsable</th><th>Début</th><th>Fin</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($activites as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $a->type_activite }}</td>
                    <td>{{ $a->responsable }}</td>
                    <td>{{ $a->date_debut->format('d/m/Y') }}</td>
                    <td>{{ $a->date_fin ? $a->date_fin->format('d/m/Y') : '—' }}</td>
                    <td><span class="badge bg-{{ $a->statut_color }}">{{ $a->statut_label }}</span></td>
                    <td>
                        <a href="{{ route('activites.show', $a) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('activites.edit', $a) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('activites.destroy', $a) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer cette activité ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune activité.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($activites->hasPages())
    <div class="card-footer">{{ $activites->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
