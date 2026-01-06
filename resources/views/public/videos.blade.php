@extends('layouts.public')

@section('title', 'Videos - NewsPortal')

@section('content')
    <div class="mb-4">
        <h2>Videos</h2>
        <p class="text-muted">Grille de reportages et capsules editoriales.</p>
    </div>

    <div class="row g-4">
        @forelse ($videos as $video)
            <div class="col-md-6 col-lg-4">
                <div class="article-card h-100">
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ $video->video_url }}" title="{{ $video->title }}" allowfullscreen></iframe>
                    </div>
                    <div class="p-3">
                        <h5>{{ $video->title }}</h5>
                        <p class="text-muted small">{{ $video->description }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-muted">Aucune video publiee.</div>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $videos->links() }}
    </div>
@endsection
