@extends('layouts.app')
@section('title','Réunions')
@section('page-title','Gestion des réunions')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-calendar-event-fill me-1" style="color:#6a1b9a;"></i> Réunions</strong>
        <a href="{{ route('reunions.create') }}" class="btn btn-sm" style="background:#6a1b9a;color:#fff;">
            <i class="bi bi-plus-lg"></i> Nouvelle réunion
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="type_reunion" class="form-select form-select-sm">
                    <option value="">-- Tous types --</option>
                    <option value="ordinaire" @selected(request('type_reunion')=='ordinaire')>Ordinaire</option>
                    <option value="extraordinaire" @selected(request('type_reunion')=='extraordinaire')>Extraordinaire</option>
                    <option value="assemblee_generale" @selected(request('type_reunion')=='assemblee_generale')>Assemblée générale</option>
                    <option value="financiere" @selected(request('type_reunion')=='financiere')>Financière</option>
                    <option value="production" @selected(request('type_reunion')=='production')>Production</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="statut" class="form-select form-select-sm">
                    <option value="">-- Tous statuts --</option>
                    <option value="planifie" @selected(request('statut')=='planifie')>Planifiée</option>
                    <option value="tenu" @selected(request('statut')=='tenu')>Tenue</option>
                    <option value="annule" @selected(request('statut')=='annule')>Annulée</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('reunions.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Titre</th><th>Type</th><th>Date</th><th>Lieu</th><th>Participants</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($reunions as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold">{{ $r->titre }}</div>
                        <small class="text-muted">{{ $r->heure ?? 'Heure non définie' }}</small>
                    </td>
                    <td><span class="badge text-bg-secondary">{{ $r->type_label }}</span></td>
                    <td>{{ $r->date_reunion->format('d/m/Y') }}</td>
                    <td>{{ $r->lieu ?? '—' }}</td>
                    <td>
                        <span class="badge text-bg-primary">
                            <i class="bi bi-people-fill me-1"></i>{{ $r->participants_count }}
                        </span>
                    </td>
                    <td><span class="badge bg-{{ $r->statut_color }}">{{ $r->statut_label }}</span></td>
                    <td>
                        <a href="{{ route('reunions.show', $r) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('reunions.edit', $r) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('reunions.destroy', $r) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Aucune réunion.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reunions->hasPages())
    <div class="card-footer">{{ $reunions->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
