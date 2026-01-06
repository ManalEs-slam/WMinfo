<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleStat;
use App\Models\Comment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $publishedArticles = Article::where('status', 'published')->count();
        $activeUsers = User::where('status', 'active')->count();
        $comments = Comment::count();
        $totalViews = Article::sum('views');

        $currentMonth = now()->format('Y-m');
        $previousMonth = now()->subMonth()->format('Y-m');

        $currentMonthViews = ArticleStat::where('stat_date', 'like', "{$currentMonth}%")->sum('views');
        $previousMonthViews = ArticleStat::where('stat_date', 'like', "{$previousMonth}%")->sum('views');

        $growth = $previousMonthViews > 0
            ? round((($currentMonthViews - $previousMonthViews) / $previousMonthViews) * 100, 1)
            : 0;

        $monthlyStats = ArticleStat::selectRaw('DATE_FORMAT(stat_date, "%b") as label, SUM(views) as value')
            ->where('stat_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('label')
            ->orderByRaw('MIN(stat_date)')
            ->get();

        return view('admin.dashboard', [
            'publishedArticles' => $publishedArticles,
            'activeUsers' => $activeUsers,
            'comments' => $comments,
            'totalViews' => $totalViews,
            'growth' => $growth,
            'monthlyStats' => $monthlyStats,
        ]);
    }
}
