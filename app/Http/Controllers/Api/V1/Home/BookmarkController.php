<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $user = Auth()->user();
        $bookmarks = $user->bookmarks()->get();
        return response()->json($bookmarks);
    }


    public function toggle(Post $post)
    {
        $bookmark = Bookmark::where(['user_id' => auth()->id(), 'post_id' => $post->id])->first();
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['success' => 'Bookmark succesfully deleted'],200);
        }
        Bookmark::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id]);

        return response()->json(['success' => 'Bookmark succesfully added'],200);
    }


}
