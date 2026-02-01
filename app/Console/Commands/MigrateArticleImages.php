<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MigrateArticleImages extends Command
{
    protected $signature = 'articles:migrate-images {--delete-old : Delete old image files after copy}';
    protected $description = 'Move featured_image files to public/uploads/articles and set image_path.';

    public function handle(): int
    {
        $articles = Article::query()
            ->whereNotNull('featured_image')
            ->where(function ($q) {
                $q->whereNull('image_path')->orWhere('image_path', '');
            })
            ->get();

        if ($articles->isEmpty()) {
            $this->info('No articles to migrate.');
            return self::SUCCESS;
        }

        $targetDir = public_path('uploads/articles');
        File::ensureDirectoryExists($targetDir);

        $copied = 0;
        $skipped = 0;

        foreach ($articles as $article) {
            $oldRel = ltrim($article->featured_image, '/');

            $candidates = [
                public_path('storage/' . $oldRel),
                storage_path('app/public/' . $oldRel),
            ];

            $sourcePath = null;
            foreach ($candidates as $candidate) {
                if (File::exists($candidate)) {
                    $sourcePath = $candidate;
                    break;
                }
            }

            if (!$sourcePath) {
                $this->warn("Missing file for article {$article->id}: {$oldRel}");
                $skipped++;
                continue;
            }

            $ext = pathinfo($sourcePath, PATHINFO_EXTENSION) ?: 'jpg';
            $fileName = time() . '_' . Str::random(10) . '.' . $ext;
            $relativePath = 'uploads/articles/' . $fileName;
            $destPath = public_path($relativePath);

            File::copy($sourcePath, $destPath);

            if ($this->option('delete-old')) {
                File::delete($sourcePath);
            }

            $article->image_path = $relativePath;
            $article->save();

            $copied++;
        }

        $this->info("Migrated: {$copied}, Skipped: {$skipped}");

        return self::SUCCESS;
    }
}
