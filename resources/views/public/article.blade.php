@extends('layouts.public')

@section('title', $article->title . ' - NewsPortal')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="category-pill mb-3">{{ $article->category?->name ?? 'General' }}</div>
            <h1 class="mb-3">{{ $article->title }}</h1>
            <div class="text-muted mb-4">
                Par {{ $article->author?->display_name ?? 'Equipe NewsPortal' }} •
                {{ $article->published_at?->format('d/m/Y') ?? 'Draft' }}
            </div>

            @if ($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" class="img-fluid rounded-4 mb-4" alt="article">
            @endif

            <div class="mb-4">{!! $article->content !!}</div>

            <div class="d-flex flex-wrap gap-2 mb-5">
                <button class="btn btn-outline-dark btn-sm">Partager LinkedIn</button>
                <button class="btn btn-outline-dark btn-sm">Partager X</button>
                <button class="btn btn-outline-dark btn-sm">Partager Facebook</button>
                @if ($preview)
                    <form method="post" action="{{ route('admin.articles.publish', $article) }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-dark btn-sm">Publier</button>
                    </form>
                @endif
            </div>

            <div class="hero-card mb-4">
                <h4>Commentaires</h4>
                <form method="post" action="{{ route('articles.comment', $article) }}">
                    @csrf
                    <textarea name="content" class="form-control mb-2" rows="3" maxlength="500" placeholder="Votre commentaire"></textarea>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted" id="charCount">0 / 500</small>
                        <button class="btn btn-dark btn-sm" @guest disabled @endguest>Envoyer</button>
                    </div>
                </form>
            </div>

            <div class="mb-5">
                @forelse ($article->comments as $comment)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="fw-semibold">{{ $comment->user?->display_name ?? 'Invite' }}</div>
                        <div class="text-muted small mb-2">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
                        <div>{{ $comment->content }}</div>
                    </div>
                @empty
                    <div class="text-muted">Aucun commentaire pour le moment.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const textarea = document.querySelector('textarea[name="content"]');
        const counter = document.getElementById('charCount');
        if (textarea && counter) {
            textarea.addEventListener('input', () => {
                counter.textContent = `${textarea.value.length} / 500`;
            });
        }
    </script>
@endpush
