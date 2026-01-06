<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['article', 'user'])->latest()->paginate(12);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Commentaire approuve.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('success', 'Commentaire rejete.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Commentaire supprime.');
    }
}
