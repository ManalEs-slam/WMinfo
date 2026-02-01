<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\File;
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

        if ($article->image_path) {
            $fullPath = public_path($article->image_path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
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

        if ($request->hasFile('image')) {
            Log::info('Image processing started.');

            if ($article?->image_path) {
                $oldPath = public_path($article->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                    Log::info('Old image deleted: ' . $article->image_path);
                }
            }

            $file = $request->file('image');
            $originalSize = $file->getSize();
            Log::info('Original image size: ' . $originalSize . ' bytes');

            $fileName = time() . '_' . Str::random(10) . '.jpg';
            $relativePath = 'uploads/articles/' . $fileName;
            $absolutePath = public_path($relativePath);
            File::ensureDirectoryExists(dirname($absolutePath));

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
            File::put($absolutePath, (string) $encoded);
            Log::info('Image stored at: ' . $relativePath);

            $data['image_path'] = $relativePath;
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
