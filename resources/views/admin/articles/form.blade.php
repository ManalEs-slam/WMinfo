@extends('layouts.admin')

@section('title', $article->exists ? 'Edition article' : 'Creation article')
@section('page_title', $article->exists ? 'Edition article' : 'Creation article')

@section('content')
    <form method="post" enctype="multipart/form-data" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}">
        @csrf
        @if ($article->exists)
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="stat-card p-4 mb-4">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" id="titleField" class="form-control mb-3" value="{{ old('title', $article->title) }}" required>

                    <label class="form-label">Slug</label>
                    <input type="text" id="slugField" class="form-control mb-3" value="{{ $article->slug }}" readonly>

                    <label class="form-label">Extrait</label>
                    <textarea name="excerpt" class="form-control mb-3" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>

                    <label class="form-label">Contenu</label>
                    <textarea name="content" id="contentEditor" class="form-control" rows="10">{{ old('content', $article->content) }}</textarea>
                </div>

                <div class="stat-card p-4">
                    <h6>Image a la une</h6>
                    <div class="border border-dashed rounded-3 p-4 text-center mb-3">
                        <input type="file" name="image" class="form-control">
                        <div class="text-muted small mt-2">Glisser deposer ou selectionner un fichier.</div>
                    </div>
                    @if ($article->image_path)
                        <img src="{{ asset($article->image_path) }}" alt="featured" class="img-fluid rounded-3">
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stat-card p-4 mb-4">
                    <h6>Parametres de publication</h6>
                    <label class="form-label mt-2">Statut</label>
                    <select name="status" class="form-select">
                        <option value="draft" @selected(old('status', $article->status) === 'draft')>Brouillon</option>
                        <option value="published" @selected(old('status', $article->status) === 'published')>Publie</option>
                    </select>

                    <label class="form-label mt-3">Visibilite</label>
                    <select name="visibility" class="form-select">
                        <option value="public" @selected(old('visibility', $article->visibility) === 'public')>Public</option>
                        <option value="private" @selected(old('visibility', $article->visibility) === 'private')>Prive</option>
                        <option value="unlisted" @selected(old('visibility', $article->visibility) === 'unlisted')>Non reference</option>
                    </select>

                    <label class="form-label mt-3">Date de publication</label>
                    <input type="datetime-local" name="published_at" class="form-control"
                           value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}">

                    <label class="form-label mt-3">Region</label>
                    <input type="text" name="region" class="form-control" value="{{ old('region', $article->region) }}">
                </div>

                <div class="stat-card p-4">
                    <h6>Categories et tags</h6>
                    <label class="form-label mt-2">Categorie</label>
                    <select name="category_id" class="form-select">
                        <option value="">Aucune</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label mt-3">Tags</label>
                    <input type="text" name="tags" class="form-control"
                           value="{{ old('tags', is_array($article->tags) ? implode(', ', $article->tags) : '') }}"
                           placeholder="Breaking, Analyse">
                </div>

                <div class="d-grid gap-2 mt-4">
                    @if ($article->exists)
                        <a href="{{ route('admin.articles.preview', $article) }}" class="btn btn-outline-secondary">Apercu</a>
                    @endif
                    <button type="submit" class="btn btn-dark" data-status="published">Publier</button>
                    <button type="submit" class="btn btn-outline-dark" data-status="draft">Enregistrer brouillon</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/n0ih57jrow9677rmjq3p651o99rd8vsjqt6q2vpgjoly51h0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#contentEditor',
            height: 420,
            plugins: 'link image lists media',
            toolbar: 'undo redo | bold italic | styles | bullist numlist | link image media',
            menubar: false
        });

        const titleField = document.getElementById('titleField');
        const slugField = document.getElementById('slugField');

        if (titleField && slugField && !slugField.value) {
            titleField.addEventListener('input', () => {
                slugField.value = titleField.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            });
        }

        document.querySelectorAll('button[data-status]').forEach(button => {
            button.addEventListener('click', () => {
                const statusField = document.querySelector('select[name="status"]');
                if (statusField) {
                    statusField.value = button.dataset.status;
                }
            });
        });
    </script>
@endpush
