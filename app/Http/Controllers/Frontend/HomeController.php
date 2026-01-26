<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\NewsletterSubscriber;

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

        $featuredArticle = (clone $publicPublishedQuery)
            ->orderByDesc('views')
            ->first();

        return view('public.home', compact('categories', 'latestArticles', 'featuredArticle'));
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
