@extends('layouts.app')
@section('title','Nouvel utilisateur')
@section('page-title','Créer un utilisateur')

@section('content')
<div class="card" style="max-width:550px;">
    <div class="card-header"><strong><i class="bi bi-person-plus-fill me-1"></i> Nouvel utilisateur</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Rôle <span class="text-danger">*</span></label>
                <select name="role" class="form-select" required>
                    <option value="admin" @selected(old('role')=='admin')>Administrateur</option>
                    <option value="secretaire" @selected(old('role')=='secretaire')>Secrétaire</option>
                    <option value="comptable" @selected(old('role','comptable')=='comptable')>Comptable</option>
                    <option value="membre" @selected(old('role')=='membre')>Membre</option>
                </select>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirmer <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark"><i class="bi bi-check-lg"></i> Créer</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
