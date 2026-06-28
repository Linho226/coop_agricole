@extends('layouts.app')
@section('title','Produits')
@section('page-title','Gestion des produits')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-box-seam-fill text-secondary me-1"></i> Produits agricoles</strong>
        <a href="{{ route('produits.create') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-plus-lg"></i> Nouveau produit
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>#</th><th>Image</th><th>Nom</th><th>Prix</th><th>Stock</th><th>Catalogue</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($produits as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($p->image)
                                <img src="{{ Storage::url($p->image) }}" class="rounded" width="46" height="46" style="object-fit:cover;">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center"
                                     style="width:46px;height:46px;background:var(--bs-tertiary-bg);font-size:1.3rem;">
                                    <i class="bi bi-box-seam text-secondary"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $p->nom }}</td>
                        <td>{{ number_format($p->prix_unitaire, 0, ',', ' ') }} F / {{ $p->unite }}</td>
                        <td>{{ number_format($p->stock_disponible, 2, ',', ' ') }} {{ $p->unite }}</td>
                        <td>
                            <span class="badge bg-{{ $p->publie ? 'success' : 'secondary' }}">
                                {{ $p->publie ? 'Publié' : 'Masqué' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('produits.show', $p) }}" class="btn btn-sm btn-outline-info" title="Détail"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('produits.edit', $p) }}" class="btn btn-sm btn-outline-warning" title="Modifier"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('produits.destroy', $p) }}" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Aucun produit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($produits->hasPages())
    <div class="card-footer">{{ $produits->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
