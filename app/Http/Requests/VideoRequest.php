<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'title_fr' => ['nullable', 'string', 'max:200'],
            'title_ar' => ['nullable', 'string', 'max:200'],
            'video_url' => ['nullable', 'url', 'max:500', 'required_without:video_file'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:51200', 'required_without:video_url'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'video_url.required_without' => 'Renseignez une URL YouTube ou importez un fichier video.',
            'video_file.required_without' => 'Renseignez une URL YouTube ou importez un fichier video.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $hasUrl = filled($this->input('video_url'));
            $hasFile = $this->hasFile('video_file');

            if ($hasUrl && $hasFile) {
                $validator->errors()->add('video_url', 'Choisissez uniquement une URL YouTube ou un fichier video.');
            }

            if (!$hasUrl && !$hasFile) {
                $validator->errors()->add('video_url', 'Renseignez une URL YouTube ou importez un fichier video.');
            }
        });
    }
}
