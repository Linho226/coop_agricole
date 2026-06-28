@php
    $isEdit = isset($cotisation);
    $selectedMonth = old('periode_mois', $cotisation->periode_mois ?? now()->month);
    $selectedYear = old('periode_annee', $cotisation->periode_annee ?? now()->year);
    $months = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
    ];
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <strong><i class="bi bi-cash-coin text-primary me-1"></i> Informations de paiement</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Membre <span class="text-danger">*</span></label>
                    <select name="membre_id" class="form-select @error('membre_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un membre</option>
                        @foreach($membres as $m)
                        <option value="{{ $m->id }}" @selected(old('membre_id', $cotisation->membre_id ?? '')==$m->id)>{{ $m->nom_complet }}</option>
                        @endforeach
                    </select>
                    @error('membre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Type de cotisation <span class="text-danger">*</span></label>
                        <select name="type_cotisation" class="form-select @error('type_cotisation') is-invalid @enderror" required>
                            @foreach($typeOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('type_cotisation', $cotisation->type_cotisation ?? 'mensuelle')==$value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type_cotisation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Mois concerné</label>
                        <select name="periode_mois" class="form-select">
                            <option value="">Aucun</option>
                            @foreach($months as $value => $label)
                            <option value="{{ $value }}" @selected((string) $selectedMonth === (string) $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Année</label>
                        <select name="periode_annee" class="form-select">
                            <option value="">Aucune</option>
                            @foreach($annees as $annee)
                            <option value="{{ $annee }}" @selected((string) $selectedYear === (string) $annee)>{{ $annee }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Montant attendu (F)</label>
                        <input type="number" name="montant_attendu" class="form-control @error('montant_attendu') is-invalid @enderror"
                               value="{{ old('montant_attendu', $cotisation->montant_attendu ?? '') }}" min="0" step="1">
                        @error('montant_attendu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Montant payé (F) <span class="text-danger">*</span></label>
                        <input type="number" name="montant" class="form-control @error('montant') is-invalid @enderror"
                               value="{{ old('montant', $cotisation->montant ?? '') }}" min="0" step="1" required>
                        @error('montant')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date de paiement <span class="text-danger">*</span></label>
                        <input type="date" name="date_paiement" class="form-control @error('date_paiement') is-invalid @enderror"
                               value="{{ old('date_paiement', isset($cotisation) ? $cotisation->date_paiement->format('Y-m-d') : date('Y-m-d')) }}" required>
                        @error('date_paiement')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mode de paiement <span class="text-danger">*</span></label>
                        <select name="mode_paiement" class="form-select @error('mode_paiement') is-invalid @enderror" required>
                            @foreach($modeOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('mode_paiement', $cotisation->mode_paiement ?? 'especes')==$value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('mode_paiement')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Statut</label>
                        <select name="statut" class="form-select">
                            @foreach($statutOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('statut', $cotisation->statut ?? 'paye')==$value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Le statut devient automatiquement “partiel” si le montant payé est inférieur au montant attendu.</div>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Observation</label>
                    <textarea name="observation" class="form-control @error('observation') is-invalid @enderror" rows="3">{{ old('observation', $cotisation->observation ?? '') }}</textarea>
                    @error('observation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <strong><i class="bi bi-receipt text-success me-1"></i> Suivi comptable</strong>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-upc-scan"></i></div>
                    <div>
                        <div class="fw-semibold">Référence automatique</div>
                        <div class="text-muted small">
                            {{ $isEdit ? $cotisation->reference_label : 'Elle sera générée après enregistrement.' }}
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-calculator"></i></div>
                    <div>
                        <div class="fw-semibold">Reste à payer</div>
                        <div class="text-muted small">Calculé avec le montant attendu et le montant payé.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn {{ $isEdit ? 'btn-warning' : 'btn-primary' }}">
                        <i class="bi bi-check-lg"></i> {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                    <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </div>
        </div>
    </div>
</div>
