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
            } else {
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
            ]);

        });
    }
}
