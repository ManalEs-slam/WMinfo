@extends('layouts.admin')

@section('title', 'Moderation des commentaires')
@section('page_title', 'Moderation des commentaires')

@section('content')
    <div class="stat-card p-0 overflow-hidden">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Article</th>
                    <th>Auteur</th>
                    <th>Commentaire</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comments as $comment)
                    <tr>
                        <td>{{ $comment->article?->title }}</td>
                        <td>{{ $comment->user?->display_name ?? 'Invite' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($comment->content, 80) }}</td>
                        <td>
                            <span class="badge bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'rejected' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <form method="post" action="{{ route('admin.comments.approve', $comment) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-success">Approuver</button>
                            </form>
                            <form method="post" action="{{ route('admin.comments.reject', $comment) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning">Rejeter</button>
                            </form>
                            <form method="post" action="{{ route('admin.comments.destroy', $comment) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aucun commentaire.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $comments->links() }}
    </div>
@endsection
