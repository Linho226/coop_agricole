@extends('layouts.app')
@section('title','Détail réunion')
@section('page-title','Détail de la réunion')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong>{{ $reunion->titre }}</strong>
        <span class="badge bg-{{ $reunion->statut_color }}">{{ $reunion->statut_label }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive"><table class="table table-borderless">
            <tr><td class="text-muted" width="150">Date</td><td>{{ $reunion->date_reunion->format('d/m/Y') }}</td></tr>
            <tr><td class="text-muted">Heure</td><td>{{ $reunion->heure ?? '—' }}</td></tr>
            <tr><td class="text-muted">Lieu</td><td>{{ $reunion->lieu ?? '—' }}</td></tr>
        </table>

        @if($reunion->ordre_du_jour)
        <div class="mb-3">
            <h6 class="fw-bold">Ordre du jour</h6>
            <div class="border rounded p-3 bg-light">{{ $reunion->ordre_du_jour }}</div>
        </div>
        @endif

        @if($reunion->compte_rendu)
        <div>
            <h6 class="fw-bold">Compte rendu</h6>
            <div class="border rounded p-3 bg-light">{{ $reunion->compte_rendu }}</div>
        </div>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('reunions.edit', $reunion) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('reunions.index') }}" class="btn btn-outline-secondary btn-sm ms-1">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>
@endsection
