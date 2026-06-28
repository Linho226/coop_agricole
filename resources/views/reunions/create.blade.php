@extends('layouts.app')
@section('title','Nouvelle réunion')
@section('page-title','Planifier une réunion')

@section('content')
<form method="POST" action="{{ route('reunions.store') }}">
    @csrf
    <div class="row g-3 align-items-start">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <strong><i class="bi bi-calendar-plus-fill me-1" style="color:#6a1b9a;"></i> Nouvelle réunion</strong>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                                   value="{{ old('titre') }}" required>
                            @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type_reunion" class="form-select">
                                <option value="ordinaire" @selected(old('type_reunion','ordinaire')=='ordinaire')>Ordinaire</option>
                                <option value="extraordinaire" @selected(old('type_reunion')=='extraordinaire')>Extraordinaire</option>
                                <option value="assemblee_generale" @selected(old('type_reunion')=='assemblee_generale')>Assemblée générale</option>
                                <option value="financiere" @selected(old('type_reunion')=='financiere')>Financière</option>
                                <option value="production" @selected(old('type_reunion')=='production')>Production</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_reunion" class="form-control"
                                   value="{{ old('date_reunion', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Heure</label>
                            <input type="time" name="heure" class="form-control" value="{{ old('heure') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="planifie" @selected(old('statut','planifie')=='planifie')>Planifiée</option>
                                <option value="tenu" @selected(old('statut')=='tenu')>Tenue</option>
                                <option value="annule" @selected(old('statut')=='annule')>Annulée</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Lieu</label>
                            <input type="text" name="lieu" class="form-control" value="{{ old('lieu') }}"
                                   placeholder="Salle de réunion, siège, parcelle...">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Ordre du jour</label>
                            <textarea name="ordre_du_jour" class="form-control" rows="3"
                                      placeholder="Un point par ligne : bilan, production, finances...">{{ old('ordre_du_jour') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Compte rendu</label>
                            <textarea name="compte_rendu" class="form-control" rows="4"
                                      placeholder="Résumé des échanges importants.">{{ old('compte_rendu') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Décisions prises</label>
                            <textarea name="decisions" class="form-control" rows="3"
                                      placeholder="Exemple : achat d’engrais validé, prix de vente fixé...">{{ old('decisions') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Actions à suivre</label>
                            <textarea name="actions_suivi" class="form-control" rows="3"
                                      placeholder="Exemple : Responsable - action - date limite">{{ old('actions_suivi') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2">
                    <button type="submit" class="btn" style="background:#6a1b9a;color:#fff;">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                    <a href="{{ route('reunions.index') }}" class="btn btn-outline-secondary">Annuler</a>
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
                                   @checked(in_array($membre->id, old('participants', [])))>
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
