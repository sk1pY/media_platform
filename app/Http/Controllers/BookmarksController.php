<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Like;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarksController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('user', 'task')->get();
        return view('bookmarks', compact('bookmarks'));


    }

    public function add(Request $request)
    {
        $taskId = $request->input('bookmark_id');
        $bookmark = Bookmark::where(['user_id' => Auth::id(),'task_id' => $taskId])->first();
        if($bookmark){
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmark' => false]);
        }
        Bookmark::create([
            'user_id' => Auth::user() -> id,
            'task_id' => $taskId]);
        return response()->json(['success' => true,  'bookmark' => true]);

    }

    Public function destroy($id){

        Bookmark::find($id)->delete();
        return redirect()->route('bookmarks.index');
    }
}
