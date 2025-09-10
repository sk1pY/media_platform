<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Subscribe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use PharIo\Manifest\Author;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['partials.nav','partials.categories_sidebar'], function ($view) {
            $view->with('categories', Category::get());
        });

        Carbon::setLocale('ru');

        View::composer('*', function ($view) {
            $top_users = Subscribe::get()
                ->groupBy('author_id')
                ->map(function ($item,$author_id){
                    $user = User::find($author_id);
                    $user->sub_count = $item->count();
                    return $user;
                })->sortByDesc('sub_count')->values()->take(3);
            $top_comments = Comment::orderBy('likes','desc')->take(5)->get();

          //  dd($top_blogs);
            if (Auth::check()) {
                $user = Auth::user();
                $likedPostUser = $user->likes()
                    ->where('likeable_type', Post::class)
                    ->pluck('likeable_id')
                    ->toArray();
                $likeCommentUser = $user->likes()
                    ->where(['likeable_type'=> Comment::class])
                    ->pluck('likeable_id')
                    ->toArray();

                $bookmarkPostUser = $user->bookmarks()->pluck('post_id')->toArray();
                $subAuthors = Subscribe::where('user_id', $user->id)->pluck('author_id')->toArray();
                $notifications = $user->notifications()->latest()->take(5)->get();
              //  dd($notifications);

            } else {
                $notifications = [];
                $likedPostUser = [];
                $bookmarkPostUser = [];
                $subAuthors = [];
                $likeCommentUser = [];

            }

            $view->with([
                'notifications' => $notifications,
                'likedPostUser' => $likedPostUser,
                'bookmarkPostUser' => $bookmarkPostUser,
                'subAuthors' => $subAuthors,
                'likeCommentUser' => $likeCommentUser,
                'top_users' => $top_users,
                'top_comments' => $top_comments,
            ]);

        });
    }
}
