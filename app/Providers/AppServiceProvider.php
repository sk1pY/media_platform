<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Subscribe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.app', function ($view) {
            $view->with('categories', Category::all());
        });

        Carbon::setLocale('ru');

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $likedPostUser = Auth::user()->likes()
                    ->where('likeable_type', Post::class)
                    ->pluck('likeable_id')
                    ->toArray();
                $likeCommentUser = Auth::user()->likes()
                    ->where(['likeable_type'=> Comment::class, 'is_liked'=> true])
                    ->pluck('likeable_id')
                    ->toArray();
                $dislikeCommentUser = Auth::user()->likes()
                    ->where(['likeable_type'=> Comment::class, 'is_liked'=> false])
                    ->pluck('likeable_id')
                    ->toArray();
                $bookmarkPostUser = Auth::user()->bookmarks()->pluck('id')->toArray();
                $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();
            } else {
                $dislikeCommentUser = [];
                $likedPostUser = [];
                $bookmarkPostUser = [];
                $subAuthors = [];
                $likeCommentUser = [];
            }

            $view->with([
                'likedPostUser' => $likedPostUser,
                'bookmarkPostUser' => $bookmarkPostUser,
                'subAuthors' => $subAuthors,
                'likeCommentUser' => $likeCommentUser,
                'dislikeCommentUser' => $dislikeCommentUser,
            ]);

        });
    }
}
