<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = CommunityPost::with('user:id,name,avatar')
            ->where('is_moderated', false)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('community.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        CommunityPost::create([
            'user_id' => Auth::id(),
            'content' => $data['content'],
        ]);

        return redirect()->route('community.index')->with('success', 'Postingan berhasil dibagikan!');
    }

    public function destroy(CommunityPost $communityPost)
    {
        if ($communityPost->user_id !== Auth::id()) {
            abort(403);
        }
        $communityPost->delete();
        return redirect()->route('community.index')->with('success', 'Postingan dihapus.');
    }
}
