@extends('layouts.app')
@section('title','Détail activité')
@section('page-title','Détail de l\'activité')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong>{{ $activite->type_activite }}</strong>
        <span class="badge bg-{{ $activite->statut_color }}">{{ $activite->statut_label }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive"><table class="table table-borderless">
            <tr><td class="text-muted" width="150">Responsable</td><td class="fw-semibold">{{ $activite->responsable }}</td></tr>
            <tr><td class="text-muted">Date début</td><td>{{ $activite->date_debut->format('d/m/Y') }}</td></tr>
            <tr><td class="text-muted">Date fin</td><td>{{ $activite->date_fin ? $activite->date_fin->format('d/m/Y') : '—' }}</td></tr>
            <tr><td class="text-muted">Description</td><td>{{ $activite->description ?? '—' }}</td></tr>
        </table>
    </div></div>
    <div class="card-footer">
        <a href="{{ route('activites.edit', $activite) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('activites.index') }}" class="btn btn-outline-secondary btn-sm ms-1">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>
@endsection
