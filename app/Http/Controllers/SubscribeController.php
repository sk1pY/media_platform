<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;
use App\Notifications\NewFollowerNotification;

class SubscribeController extends Controller
{

    public function index()
    {
        $subscriptions = Subscribe::where('user_id', Auth::id())->pluck('author_id')->toArray();
        $authors = User::whereIn('id', $subscriptions)->get();

        return view('home.subscriptions', compact('authors'));
    }

    public function subscribe(Request $request)
    {

        $this->authorize('subscribe_users', User::class);

        $author_id = $request->input('author_id');
        $user_id = Auth::id();
        $sub = Subscribe::where('author_id', $author_id)->where('user_id', $user_id)->first();

        if ($sub) {
            $sub->delete();
            return response()->json(['success' => true, 'sub' => false]);
        }
        Subscribe::create(['author_id' => $author_id, 'user_id' => $user_id]);
        $follower = auth()->user();
        $targetUser = User::findOrFail($author_id);
        $targetUser->notify(new NewFollowerNotification($follower));
        return response()->json(['success' => true, 'sub' => true]);


    }
}
