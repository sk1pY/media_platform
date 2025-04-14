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
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\admin\ClaimController;
use App\Http\Controllers\CategoryController;


//CATEGORIES
Route::prefix('categories')->name('categories.')
    ->group(function () {
        Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('show');
        Route::get('/my_feed', [CategoryController::class, 'my_feed'])->name('my_feed');
        Route::get('/newest', [CategoryController::class, 'newest'])->name('newest');
        Route::get('/popular', [CategoryController::class, 'popular'])->name('popular');
    });

//POSTS
Route::get('/', [PostController::class, 'index'])->name('index');
Route::resource('posts', PostController::class)->only(['show', 'store', 'update', 'destroy']);
Route::get('posts/hidden', [PostController::class, 'hidden_posts'])->name('posts.hidden');
Route::post('posts/{post}/hide', [PostController::class, 'hide'])->name('posts.hide');


//HOME
Route::name('home.')->prefix('home')->group(function () {
    Route::get('/{user}', [HomeController::class, 'show'])->name('profile.show');
    Route::put('/update_profile/{id}', [HomeController::class, 'update_profile'])->name('update.profile');
    Route::put('/update_post/{post}', [HomeController::class, 'update_post'])->name('update.post');
});


//COMMENTARIES
Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
Route::post('/comments/like_dislike', [CommentController::class, 'like_dislike'])->name('comments.like');
//right sidebar
Route::get('/comments', [CommentController::class, 'user_comments'])->name('comments.index');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

//LIKES
Route::post('/like-post', [LikeController::class, 'like'])->name('like_post');

//SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//VIEW
Route::post('/posts/{post}/incrementViews', [PostController::class, 'incrementViews'])->name('posts.incrementViews');

//ADMIN_PANEL
Route::name('admin.')->prefix('admin')->middleware(['role:admin'])->group(function () {
    //ROLEPERMISSIONS
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/roles', [RolePermissionController::class, 'roles_store'])->name('roles.store');
    Route::delete('/roles/{role}', [RolePermissionController::class, 'roles_destroy'])->name('roles.destroy');
    Route::post('/permissions', [RolePermissionController::class, 'permissions_store'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [RolePermissionController::class, 'permissions_destroy'])->name('permissions.destroy');
    Route::get('/roles_and_permissions', [RolePermissionController::class, 'index'])->name('roles_and_permissions.index');
    Route::put('/roles_and_permissions/{role}', [RolePermissionController::class, 'roles_and_permissions_update'])->name('roles_and_permissions.update');
    //Users
    Route::resource('users', AdminUserController::class);
    Route::put('/users/{user}/update-status', [AdminUserController::class, 'update_status'])->name('users.update.status');
    Route::put('/users/{user}/update-role', [AdminUserController::class, 'update_role'])->name('users.update.role');
    //CATEGORY
    Route::resource('categories', AdminCategoryController::class);
    //POSTS
    Route::resource('posts', AdminPostController::class);
    Route::put('/posts/{post}/update-status', [AdminPostController::class, 'update_status'])->name('posts.update.status');
    //COMMENTS
    Route::resource('comments', AdminCommentController::class);
    //CLAIMS
    Route::resource('claims', ClaimController::class);
});
//BOOKMARKS
Route::name('bookmarks.')->prefix('bookmarks')->group(function () {
    Route::get('/', [BookmarksController::class, 'index'])->name('index');
    Route::post('/', [BookmarksController::class, 'store'])->name('store');
    Route::delete('/{bookmark}', [BookmarksController::class, 'destroy'])->name('destroy');
});
//SUBSCRIBE
Route::get('/subscriptions', [SubscribeController::class, 'index'])->name('subscriptions.index');
Route::post('/subscriptions', [SubscribeController::class, 'add']);

////////////////////////////////////////////////////////////////////////////////////////////////////////
//Route::fallback(function(){
//   return view('error.error');
//});



