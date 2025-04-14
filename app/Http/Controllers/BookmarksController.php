<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarksController extends Controller
{
    public function index(): View|Factory|Application
    {
        $bookmarks = Bookmark::with('user', 'post')->get();
        return view('right_sidebar.bookmarks', compact('bookmarks'));


    }

    public function store(Request $request): JsonResponse
    {
        $postId = request('bookmark_id');
        $bookmark = Bookmark::where(['user_id' => Auth::id(), 'post_id' => $postId])->first();
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmark' => false]);
        }
        Bookmark::create([
            'user_id' => Auth::id(),
            'post_id' => $postId]);

        return response()->json(['success' => true, 'bookmark' => true]);

    }

    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();
        return redirect()->route('bookmarks.index');
    }
}
