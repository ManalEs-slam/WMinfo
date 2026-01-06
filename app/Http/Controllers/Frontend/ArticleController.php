<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\ArticleStat;
use App\Models\Category;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        if ($article->status !== 'published' || $article->visibility !== 'public') {
            abort(404);
        }

        $article->increment('views');

        ArticleStat::updateOrCreate(
            ['article_id' => $article->id, 'stat_date' => now()->startOfMonth()],
            ['views' => $article->views]
        );

        $article->load(['author', 'category', 'comments' => function ($query) {
            $query->where('status', 'approved')->latest();
        }]);

        return view('public.article', [
            'article' => $article,
            'preview' => false,
        ]);
    }

    public function category(Category $category)
    {
        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['author', 'category'])
            ->paginate(9)
            ->withQueryString();

        return view('public.category', compact('category', 'articles'));
    }

    public function comment(CommentRequest $request, Article $article)
    {
        if ($article->status !== 'published') {
            return back()->with('error', 'Article non publie.');
        }

        $article->comments()->create([
            'user_id' => $request->user()?->id,
            'content' => $request->validated()['content'],
            'status' => 'pending',
        ]);

        ArticleStat::updateOrCreate(
            ['article_id' => $article->id, 'stat_date' => now()->startOfMonth()],
            ['comments_count' => $article->comments()->where('status', 'approved')->count()]
        );

        return back()->with('success', 'Commentaire envoye pour moderation.');
    }
}
