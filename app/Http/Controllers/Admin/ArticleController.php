<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ArticleController extends Controller
{
    public function index()
    {
        $query = Article::query()->with(['author', 'category']);

        if (auth()->user()?->isEditor()) {
            $query->where('user_id', auth()->id());
        }

        $query->when(request('region'), fn ($q) => $q->where('region', request('region')))
            ->when(request('category'), fn ($q) => $q->where('category_id', request('category')))
            ->when(request('author'), fn ($q) => $q->where('user_id', request('author')))
            ->when(request('search'), function ($q) {
                $term = request('search');
                $q->where('title', 'like', "%{$term}%");
            });

        $articles = $query->latest()->paginate(10)->withQueryString();

        return view('admin.articles.index', [
            'articles' => $articles,
            'categories' => Category::orderBy('name')->get(),
            'authors' => User::whereIn('role', ['admin', 'editor'])->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        return view('admin.articles.form', [
            'article' => new Article(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(ArticleRequest $request)
    {
        $this->authorize('create', Article::class);

        $data = $this->prepareData($request);
        $data['user_id'] = auth()->id();

        $article = Article::create($data);

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Article cree.');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        return view('admin.articles.form', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $data = $this->prepareData($request, $article);
        $article->update($data);

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Article mis a jour.');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article supprime.');
    }

    public function preview(Article $article)
    {
        $this->authorize('view', $article);

        return view('public.article', [
            'article' => $article,
            'preview' => true,
        ]);
    }

    public function publish(Article $article)
    {
        $this->authorize('publish', $article);

        $article->update([
            'status' => 'published',
            'published_at' => $article->published_at ?? now(),
        ]);

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Article publie.');
    }

    private function prepareData(ArticleRequest $request, ?Article $article = null): array
    {
        $data = $request->validated();

        $data['content'] = $this->sanitizeHtml($data['content']);
        if (!empty($data['excerpt'])) {
            $data['excerpt'] = strip_tags($data['excerpt']);
        }

        $data['slug'] = $article?->slug ?? $this->uniqueSlug($data['title']);
        $data['tags'] = $this->normalizeTags($data['tags'] ?? null);

        if ($request->hasFile('featured_image')) {
            Log::info('Image processing started.');

            if ($article?->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
                Log::info('Old image deleted: ' . $article->featured_image);
            }

            $file = $request->file('featured_image');
            $originalSize = $file->getSize();
            Log::info('Original image size: ' . $originalSize . ' bytes');

            $path = 'articles/' . $file->hashName();

            // Create an image manager instance
            $manager = new ImageManager(new Driver());

            // Read the image from the uploaded file
            $image = $manager->read($file);
            Log::info('Original image dimensions: ' . $image->width() . 'x' . $image->height());

            // Resize the image to a max width of 800px and constrain aspect ratio
            $image->scale(width: 800);
            Log::info('Resized image dimensions: ' . $image->width() . 'x' . $image->height());

            // Encode the image to JPEG format with 80% quality
            $encoded = $image->toJpeg(80);
            $processedSize = strlen((string) $encoded);
            Log::info('Processed image size: ' . $processedSize . ' bytes');

            // Store the processed image
            Storage::disk('public')->put($path, (string) $encoded);
            Log::info('Image stored at: ' . $path);

            $data['featured_image'] = $path;
        } else {
            Log::info('No featured image uploaded.');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    private function normalizeTags(?string $tags): ?array
    {
        if (!$tags) {
            return null;
        }

        return collect(explode(',', $tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
    }

    private function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function sanitizeHtml(string $value): string
    {
        $allowed = '<p><br><strong><em><ul><ol><li><a><h2><h3><h4><blockquote><img>';
        $clean = strip_tags($value, $allowed);
        $clean = preg_replace('/on\w+="[^"]*"/i', '', $clean);
        $clean = preg_replace("/on\w+='[^']*'/i", '', $clean);
        $clean = preg_replace('/javascript:/i', '', $clean);

        return $clean ?? '';
    }
}
