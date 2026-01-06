<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'stat_date',
        'views',
        'comments_count',
        'shares_count',
    ];

    protected $casts = [
        'stat_date' => 'date',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
