@extends('layouts.admin')

@section('title', 'Gestion des videos')
@section('page_title', 'Gestion des videos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-muted">Bibliotheque video et publications</div>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">Ajouter une video</a>
    </div>

    <div class="stat-card p-0 overflow-hidden">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Publication</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($videos as $video)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $video->title }}</div>
                            <div class="text-muted small">{{ $video->video_url }}</div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $video->status === 'published' ? 'success' : 'secondary' }}">
                                {{ ucfirst($video->status) }}
                            </span>
                        </td>
                        <td>{{ $video->published_at?->format('d/m/Y') ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-outline-primary">Editer</a>
                            <form method="post" action="{{ route('admin.videos.destroy', $video) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Aucune video.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $videos->links() }}
    </div>
@endsection
