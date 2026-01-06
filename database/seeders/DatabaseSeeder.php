<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleStat;
use App\Models\Category;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin NewsPortal',
            'first_name' => 'Admin',
            'last_name' => 'NewsPortal',
            'email' => 'admin@newsportal.test',
            'role' => User::ROLE_ADMIN,
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        $editor = User::create([
            'name' => 'Editor NewsPortal',
            'first_name' => 'Editor',
            'last_name' => 'NewsPortal',
            'email' => 'editor@newsportal.test',
            'role' => User::ROLE_EDITOR,
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        $reader = User::create([
            'name' => 'Reader NewsPortal',
            'first_name' => 'Reader',
            'last_name' => 'NewsPortal',
            'email' => 'reader@newsportal.test',
            'role' => User::ROLE_READER,
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        $categories = collect([
            'Politique',
            'Economie',
            'Technologie',
            'Culture',
            'Sport',
            'International',
        ])->map(function (string $name) {
            return Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'is_active' => true,
            ]);
        });

        $articles = collect(range(1, 8))->map(function (int $index) use ($editor, $categories) {
            $title = "Article phare {$index}";

            return Article::create([
                'user_id' => $editor->id,
                'category_id' => $categories->random()->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => 'Une analyse claire et rapide des faits essentiels du jour.',
                'content' => '<p>Contenu riche pour l article. Structurez avec des paragraphes et des titres.</p>',
                'region' => 'Europe',
                'status' => $index % 2 === 0 ? 'published' : 'draft',
                'visibility' => 'public',
                'tags' => ['Breaking', 'Analyse'],
                'published_at' => now()->subDays(10 - $index),
                'views' => random_int(120, 1800),
            ]);
        });

        $articles->each(function (Article $article) use ($reader): void {
            Comment::create([
                'article_id' => $article->id,
                'user_id' => $reader->id,
                'content' => 'Merci pour cet article, tres instructif.',
                'status' => 'approved',
            ]);

            ArticleStat::create([
                'article_id' => $article->id,
                'stat_date' => now()->startOfMonth(),
                'views' => $article->views,
                'comments_count' => 1,
                'shares_count' => random_int(0, 15),
            ]);
        });

        NewsletterSubscriber::create([
            'email' => 'subscriber@newsportal.test',
            'status' => 'subscribed',
        ]);

        collect(range(1, 6))->each(function (int $index) {
            $title = "Video reportage {$index}";

            Video::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail' => null,
                'description' => 'Court reportage video sur les sujets du moment.',
                'status' => 'published',
                'published_at' => now()->subDays($index),
            ]);
        });
    }
}
