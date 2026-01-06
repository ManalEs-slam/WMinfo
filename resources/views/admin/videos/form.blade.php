@extends('layouts.admin')

@section('title', $video->exists ? 'Edition video' : 'Ajout video')
@section('page_title', $video->exists ? 'Edition video' : 'Ajout video')

@section('content')
    <form method="post" enctype="multipart/form-data" action="{{ $video->exists ? route('admin.videos.update', $video) : route('admin.videos.store') }}">
        @csrf
        @if ($video->exists)
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="stat-card p-4 mb-4">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control mb-3" value="{{ old('title', $video->title) }}" required>

                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control mb-3" value="{{ $video->slug }}" readonly>

                    <label class="form-label">URL video (embed)</label>
                    <input type="text" name="video_url" class="form-control mb-3" value="{{ old('video_url', $video->video_url) }}" placeholder="https://www.youtube.com/embed/...">

                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $video->description) }}</textarea>
                </div>

                <div class="stat-card p-4">
                    <h6>Miniature</h6>
                    <input type="file" name="thumbnail" class="form-control">
                    @if ($video->thumbnail)
                        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="thumbnail" class="img-fluid rounded-3 mt-3">
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stat-card p-4 mb-4">
                    <h6>Publication</h6>
                    <label class="form-label mt-2">Statut</label>
                    <select name="status" class="form-select">
                        <option value="draft" @selected(old('status', $video->status) === 'draft')>Brouillon</option>
                        <option value="published" @selected(old('status', $video->status) === 'published')>Publie</option>
                    </select>

                    <label class="form-label mt-3">Date de publication</label>
                    <input type="datetime-local" name="published_at" class="form-control"
                           value="{{ old('published_at', optional($video->published_at)->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="d-grid">
                    <button class="btn btn-dark">Sauvegarder</button>
                </div>
            </div>
        </div>
    </form>
@endsection
