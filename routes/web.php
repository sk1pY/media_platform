<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BookmarksController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\admin\ComplainController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\admin\ClaimController;

//POSTS
Route::controller(PostController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/categories/{category}', 'categories')->name('categories.show');
    Route::get('/posts/{post}', 'show')->name('posts.show');
    Route::post('/posts', 'store')->name('posts.store');
    Route::delete('/posts/{post}', 'destroy')->name('posts.destroy')->where('id', '[0-9]+');
    Route::put('/posts/{post}', 'update')->name('posts.update');
    Route::get('/my_feed', 'my_feed')->name('my_feed');
    Route::get('/newest', 'newest')->name('newest');
    Route::get('/popular', 'popular')->name('popular');
    Route::get('/hidden_posts', 'hidden_posts')->name('hidden_posts');
    Route::post('/posts/{post}/hide', 'hide')->name('posts.hide');
});

//HOME
Route::name('home.')->prefix('home')->group(function () {
    Route::get('/{user}', [HomeController::class, 'show'])->name('profile.show');
    Route::put('/update_profile/{id}', [HomeController::class, 'update_profile'])->name('update.profile');
    Route::put('/update_post/{post}', [HomeController::class, 'update_post'])->name('update.post');
});


//COMMENTARIES
Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
Route::post('/comments/like_dislike', [CommentController::class, 'like_dislike'])->name('comments.like');
Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

//LIKES
Route::post('/like-post', [LikeController::class, 'like'])->name('like_post');

//SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//VIEW
Route::post('/posts/{post}/incrementViews', [PostController::class, 'incrementViews'])->name('posts.incrementViews');

//ADMIN_PANEL
Route::name('admin.')->prefix('admin')->middleware(['role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/roles', [RolePermissionController::class, 'roles_store'])->name('roles.store');
    Route::delete('/roles/{role}', [RolePermissionController::class, 'roles_destroy'])->name('roles.destroy');
    Route::post('/permissions', [RolePermissionController::class, 'permissions_store'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [RolePermissionController::class, 'permissions_destroy'])->name('permissions.destroy');
    Route::get('/roles_and_permissions', [RolePermissionController::class, 'index'])->name('roles_and_permissions.index');
    Route::put('/roles_and_permissions/{role}', [RolePermissionController::class, 'roles_and_permissions_update'])->name('roles_and_permissions.update');
    Route::put('/role_for_user/{user}', [RolePermissionController::class, 'role_for_user'])->name('role_for_user.update');
    Route::delete('/role_for_user/{user}', [RolePermissionController::class, 'role_for_user'])->name('role_for_user.update');

    Route::resource('users', AdminUserController::class);
    Route::put('/users/{user}/update-status', [AdminUserController::class, 'update_status'])->name('users.update.status');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('posts', AdminPostController::class);
    Route::put('/posts/{post}/update-status', [AdminPostController::class, 'update_status'])->name('posts.update.status');
    Route::resource('comments', AdminCommentController::class);

    //CLAIMS
    Route::resource('claims', ClaimController::class);
});


//BOOKMARKS
Route::name('bookmarks.')->prefix('bookmarks')->group(function () {
    Route::get('/', [BookmarksController::class, 'index'])->name('index');
    Route::post('/', [BookmarksController::class, 'store']);
    Route::delete('/{bookmark}', [BookmarksController::class, 'destroy'])->name('destroy');
});


//SUBSCRIBE
Route::get('/subscriptions', [SubscribeController::class, 'index'])->name('subscriptions.index');
Route::post('/subscriptions', [SubscribeController::class, 'add']);

////////////////////////////////////////////////////////////////////////////////////////////////////////
//Route::fallback(function(){
//   return view('error.error');
//});



