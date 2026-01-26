<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getNameTranslatedAttribute()
    {
        if (app()->getLocale() !== 'ar') {
            return $this->name;
        }

        $translations = [
            'technologie' => 'تكنولوجيا',
            'sport' => 'رياضة',
            'politique' => 'سياسة',
            'international' => 'دولي',
            'economie' => 'اقتصاد',
            'culture' => 'ثقافة',
        ];

        return $translations[strtolower($this->slug ?? '')] ?? $this->name;
    }
}
