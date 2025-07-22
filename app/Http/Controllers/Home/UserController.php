<?php

namespace App\Http\Controllers\Home;

use App\Actions\Post\FilterPosts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\UserUpdateRequest;
use App\Models\Subscribe;
use App\Models\User;
use App\Services\UserUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index()
    {
        //
    }


    public function show(
        User        $user,
        FilterPosts $filterPosts,
        Request     $request):View
    {
        abort_if(!$user->status, 404);

        $postQuery = $user->posts()->withcount('comments');
        $filter = $request->get('filter');
        $filterPosts->execute($postQuery, $filter);
        $posts = $postQuery->get();
        $countSubAuthors = Subscribe::where('author_id', $user->id)->count();
        return view('front.user_page', compact('user', 'posts', 'countSubAuthors'));

    }

    public function edit():View
    {
        $user = Auth::user();
        return view('home.profile_edit', compact('user'));

    }

    public function update(UserUpdateRequest $request, UserUpdateService $userUpdateService)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $userUpdateService->handle($user, $validated,$request->file('image'),$request->file('image_cover'));


        return back()->with('success', 'Профиль успешно обновлен');

    }

    public function destroy(User $user)
    {
        $user->delete();
        return to_route('index');

    }

    public function topUsers()
    {
        $top_users_full = Subscribe::get()
            ->groupBy('author_id')
            ->map(function ($item,$author_id){
                $user = User::find($author_id);
                $user->sub_count = $item->count();
                return $user;
            })->sortByDesc('sub_count')->values();

        return view('front.top_users', compact('top_users_full'));
    }
}
