@extends('layouts.app')
@section('title','Modifier utilisateur')
@section('page-title','Modifier un utilisateur')

@section('content')
<div class="card" style="max-width:550px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier : {{ $user->name }}</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Rôle</label>
                    <select name="role" class="form-select">
                        <option value="admin" @selected($user->role=='admin')>Administrateur</option>
                        <option value="secretaire" @selected($user->role=='secretaire')>Secrétaire</option>
                        <option value="comptable" @selected($user->role=='comptable')>Comptable</option>
                        <option value="membre" @selected($user->role=='membre')>Membre</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Statut</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="actif" value="1" id="actif"
                               @checked($user->actif)>
                        <label class="form-check-label" for="actif">Compte actif</label>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nouveau mot de passe <small class="text-muted">(facultatif)</small></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirmer</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
