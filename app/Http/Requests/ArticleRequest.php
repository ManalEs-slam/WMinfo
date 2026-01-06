<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'region' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status' => ['required', 'in:draft,published'],
            'visibility' => ['required', 'in:public,private,unlisted'],
            'tags' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
