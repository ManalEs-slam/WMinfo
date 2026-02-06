<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $publicPublishedQuery = Article::query()
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->with(['author', 'category']);

        $latestArticles = $publicPublishedQuery
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        $latestForSlider = (clone $publicPublishedQuery)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $trendingArticles = (clone $publicPublishedQuery)
            ->orderByDesc('views')
            ->take(10)
            ->get();

        $sliderArticles = $trendingArticles
            ->merge($latestForSlider)
            ->unique('id')
            ->take(10)
            ->values();

        $featuredArticle = (clone $publicPublishedQuery)
            ->orderByDesc('views')
            ->first();

        $videos = Video::query()
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->take(6)
            ->get();

        return view('public.home', compact('categories', 'latestArticles', 'featuredArticle', 'videos', 'sliderArticles'));
    }

    public function search()
    {
        $term = request('q');

        $articles = Article::published()
            ->when($term, fn ($q) => $q->where('title', 'like', "%{$term}%"))
            ->with(['author', 'category'])
            ->paginate(9)
            ->withQueryString();

        return view('public.search', compact('articles', 'term'));
    }

    public function subscribe(NewsletterRequest $request)
    {
        NewsletterSubscriber::updateOrCreate(
            ['email' => $request->validated()['email']],
            ['status' => 'subscribed']
        );

        return back()->with('success', 'Inscription newsletter reussie.');
    }
}
