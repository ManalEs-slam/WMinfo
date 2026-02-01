<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.form', [
            'video' => new Video(),
        ]);
    }

    public function store(VideoRequest $request)
    {
        $data = $this->prepareData($request);
        $video = Video::create($data);

        return redirect()->route('admin.videos.edit', $video)->with('success', 'Video creee.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.form', compact('video'));
    }

    public function update(VideoRequest $request, Video $video)
    {
        $data = $this->prepareData($request, $video);
        $video->update($data);

        return redirect()->route('admin.videos.edit', $video)->with('success', 'Video mise a jour.');
    }

    public function destroy(Video $video)
    {
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video supprimee.');
    }

    private function prepareData(VideoRequest $request, ?Video $video = null): array
    {
        $data = $request->validated();
        $data['slug'] = $video?->slug ?? $this->uniqueSlug($data['title']);
        $data['title_fr'] = $data['title_fr'] ?? $data['title'] ?? null;
        $data['title_ar'] = $data['title_ar'] ?? null;

        if ($request->hasFile('thumbnail')) {
            if ($video?->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Video::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
