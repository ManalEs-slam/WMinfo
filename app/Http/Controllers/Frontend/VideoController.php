<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        return view('public.videos', compact('videos'));
    }
}
