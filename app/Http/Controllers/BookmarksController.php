<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarksController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('user', 'post')->get();
        return view('bookmarks', compact('bookmarks'));


    }

    public function add(Request $request)
    {
        $postId = $request->input('bookmark_id');

        $bookmark = Bookmark::where(['user_id' => Auth::id(),'post_id' => $postId])->first();
        if($bookmark){
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmark' => false]);
        }
        Bookmark::create([
            'user_id' => Auth::user() -> id,
            'post_id' => $postId]);
        return response()->json(['success' => true,  'bookmark' => true]);

    }

    public function destroy($id){

        Bookmark::find($id)->delete();
        return redirect()->route('bookmarks.index');
    }
}
