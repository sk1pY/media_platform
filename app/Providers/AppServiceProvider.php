<?php

namespace App\Providers;

use App\Models\Category;
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
            if (Auth::guard()->check()) {
                $likedPostUser = Auth::user()->likes()->pluck('post_id')->toArray();
                $bookmarkPostUser = Auth::user()->posts()->pluck('id')->toArray();
                $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();
            } else {
                $likedPostUser = [];
                $bookmarkPostUser = [];
                $subAuthors = [];
            }

            $view->with([
                'likedPostUser' => $likedPostUser,
                'bookmarkPostUser' => $bookmarkPostUser,
                'subAuthors' => $subAuthors
            ]);

        });
    }
}
