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
                        @if ($video->video_url)
                            @php
                                $embedUrl = $video->video_url;
                                if (!str_contains($embedUrl, 'youtube.com/embed/') && !str_contains($embedUrl, 'youtu.be/')) {
                                    preg_match('/[?&]v=([A-Za-z0-9_-]+)/', $embedUrl, $matches);
                                    $embedUrl = $matches[1] ?? '';
                                    $embedUrl = $embedUrl ? 'https://www.youtube.com/embed/' . $embedUrl : '';
                                }
                                if (str_contains($embedUrl, 'youtu.be/')) {
                                    $parts = explode('youtu.be/', $embedUrl);
                                    $embedUrl = isset($parts[1]) ? 'https://www.youtube.com/embed/' . $parts[1] : '';
                                }
                            @endphp
                            @if ($embedUrl)
                                <iframe src="{{ $embedUrl }}" title="{{ app()->getLocale() === 'ar' ? ($video->title_ar ?: $video->title_fr ?: $video->title) : ($video->title_fr ?: $video->title) }}" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                            @endif
                        @elseif ($video->video_file)
                            <video controls preload="metadata">
                                <source src="{{ asset('storage/' . $video->video_file) }}" type="video/mp4">
                                Votre navigateur ne prend pas en charge la video.
                            </video>
                        @endif
                    </div>
                    <div class="p-3">
                        <h5>{{ app()->getLocale() === 'ar' ? ($video->title_ar ?: $video->title_fr ?: $video->title) : ($video->title_fr ?: $video->title) }}</h5>
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
