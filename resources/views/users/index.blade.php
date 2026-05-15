@extends('layouts.app')
@section('title','Utilisateurs')
@section('page-title','Gestion des utilisateurs')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-person-lock text-dark me-1"></i> Utilisateurs</strong>
        <a href="{{ route('users.create') }}" class="btn btn-dark btn-sm">
            <i class="bi bi-plus-lg"></i> Nouvel utilisateur
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php
                            $roleColors = ['admin'=>'danger','secretaire'=>'info','comptable'=>'warning','membre'=>'success'];
                            $roleLabels = ['admin'=>'Administrateur','secretaire'=>'Secrétaire','comptable'=>'Comptable','membre'=>'Membre'];
                        @endphp
                        <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                            {{ $roleLabels[$user->role] ?? $user->role }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $user->actif ? 'success' : 'secondary' }}">
                            {{ $user->actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">{{ $users->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
