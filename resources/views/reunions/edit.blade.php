@extends('layouts.app')
@section('title','Modifier réunion')
@section('page-title','Modifier une réunion')

@section('content')
@php
    $selectedParticipants = old('participants', $reunion->participants->pluck('id')->map(fn ($id) => (string) $id)->all());
@endphp

<form method="POST" action="{{ route('reunions.update', $reunion) }}">
    @csrf
    @method('PUT')
    <div class="row g-3 align-items-start">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <strong><i class="bi bi-pencil text-warning me-1"></i> Modifier la réunion</strong>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="titre" class="form-control"
                                   value="{{ old('titre', $reunion->titre) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type_reunion" class="form-select">
                                <option value="ordinaire" @selected(old('type_reunion', $reunion->type_reunion)=='ordinaire')>Ordinaire</option>
                                <option value="extraordinaire" @selected(old('type_reunion', $reunion->type_reunion)=='extraordinaire')>Extraordinaire</option>
                                <option value="assemblee_generale" @selected(old('type_reunion', $reunion->type_reunion)=='assemblee_generale')>Assemblée générale</option>
                                <option value="financiere" @selected(old('type_reunion', $reunion->type_reunion)=='financiere')>Financière</option>
                                <option value="production" @selected(old('type_reunion', $reunion->type_reunion)=='production')>Production</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_reunion" class="form-control"
                                   value="{{ old('date_reunion', $reunion->date_reunion->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Heure</label>
                            <input type="time" name="heure" class="form-control" value="{{ old('heure', $reunion->heure ? substr($reunion->heure, 0, 5) : null) }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="planifie" @selected(old('statut', $reunion->statut)=='planifie')>Planifiée</option>
                                <option value="tenu" @selected(old('statut', $reunion->statut)=='tenu')>Tenue</option>
                                <option value="annule" @selected(old('statut', $reunion->statut)=='annule')>Annulée</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Lieu</label>
                            <input type="text" name="lieu" class="form-control" value="{{ old('lieu', $reunion->lieu) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Ordre du jour</label>
                            <textarea name="ordre_du_jour" class="form-control" rows="3">{{ old('ordre_du_jour', $reunion->ordre_du_jour) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Compte rendu</label>
                            <textarea name="compte_rendu" class="form-control" rows="4">{{ old('compte_rendu', $reunion->compte_rendu) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Décisions prises</label>
                            <textarea name="decisions" class="form-control" rows="3">{{ old('decisions', $reunion->decisions) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Actions à suivre</label>
                            <textarea name="actions_suivi" class="form-control" rows="3">{{ old('actions_suivi', $reunion->actions_suivi) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                    <a href="{{ route('reunions.show', $reunion) }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <strong><i class="bi bi-people-fill text-primary me-1"></i> Participants présents</strong>
                </div>
                <div class="card-body" style="max-height:520px;overflow:auto;">
                    @forelse($membres as $membre)
                        <div class="form-check py-2 border-bottom">
                            <input class="form-check-input" type="checkbox" name="participants[]"
                                   value="{{ $membre->id }}" id="membre{{ $membre->id }}"
                                   @checked(in_array((string) $membre->id, $selectedParticipants, true))>
                            <label class="form-check-label" for="membre{{ $membre->id }}">
                                <span class="fw-semibold">{{ $membre->nom_complet }}</span>
                                <br><small class="text-muted">{{ $membre->telephone ?? 'Téléphone non renseigné' }}</small>
                            </label>
                        </div>
                    @empty
                        <div class="text-muted text-center py-4">Aucun membre actif disponible.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
