@extends('layouts.app')
@section('title','Détail réunion')
@section('page-title','Détail de la réunion')

@section('content')
<div class="row g-3 align-items-start">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <strong>{{ $reunion->titre }}</strong>
                    <div class="text-muted small">{{ $reunion->type_label }}</div>
                </div>
                <span class="badge bg-{{ $reunion->statut_color }}">{{ $reunion->statut_label }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Date</div>
                            <div class="fw-bold">{{ $reunion->date_reunion->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Heure</div>
                            <div class="fw-bold">{{ $reunion->heure ?? 'Non définie' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Lieu</div>
                            <div class="fw-bold">{{ $reunion->lieu ?? 'Non renseigné' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold"><i class="bi bi-list-check text-primary me-1"></i> Ordre du jour</h6>
                    <div class="border rounded p-3" style="white-space:pre-wrap;">{{ $reunion->ordre_du_jour ?: 'Aucun ordre du jour renseigné.' }}</div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold"><i class="bi bi-journal-text text-info me-1"></i> Compte rendu</h6>
                    <div class="border rounded p-3" style="white-space:pre-wrap;">{{ $reunion->compte_rendu ?: 'Aucun compte rendu renseigné.' }}</div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold"><i class="bi bi-check2-circle text-success me-1"></i> Décisions prises</h6>
                    <div class="border rounded p-3" style="white-space:pre-wrap;">{{ $reunion->decisions ?: 'Aucune décision renseignée.' }}</div>
                </div>

                <div>
                    <h6 class="fw-bold"><i class="bi bi-arrow-repeat text-warning me-1"></i> Actions à suivre</h6>
                    <div class="border rounded p-3" style="white-space:pre-wrap;">{{ $reunion->actions_suivi ?: 'Aucune action de suivi renseignée.' }}</div>
                </div>
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
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong><i class="bi bi-people-fill text-primary me-1"></i> Participants présents</strong>
                <span class="badge text-bg-primary">{{ $reunion->participants->count() }}</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($reunion->participants as $membre)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div class="fw-semibold">{{ $membre->nom_complet }}</div>
                                <small class="text-muted">{{ $membre->telephone ?? 'Téléphone non renseigné' }}</small>
                            </div>
                            <span class="badge text-bg-success">Présent</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-4">Aucun participant renseigné.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
