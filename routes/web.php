<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ClaimController as AdminClaimController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RolesPermisions\PermissionController;
use App\Http\Controllers\Admin\RolesPermisions\RoleController;
use App\Http\Controllers\Admin\RolesPermisions\RolePermissionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//PUBLIC PAGE USER
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
//PROFILE
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::get('/posts', [PostController::class, 'profilePosts'])->name('posts');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::get('/comments', [CommentController::class, 'allCommentsInProfile'])->name('comments.index');
    //BOOKMARKS
    Route::resource('bookmarks', BookmarkController::class)->only(['index', 'store', 'destroy']);
    //subscriptions
    Route::get('/subscriptions', [SubscribeController::class, 'index'])->name('subscriptions.index');
    Route::get('/hidden-posts', [PostController::class, 'hidden_posts'])->name('hiddenPosts');

});

//SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//CATEGORIES
Route::get('/categories-special/{slug}', [CategoryController::class, 'specialCategories'])->whereIn('slug', ['popular', 'fresh', 'myFeed'])->name('specialCategories.show');
Route::get('categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

//POSTS
Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::resource('posts', PostController::class)->only(['store', 'destroy', 'update']);
Route::post('posts/{post}/hide', [PostController::class, 'hide'])->name('posts.hide');


//COMMENTS
Route::resource('posts.comments', CommentController::class)->only(['destroy', 'index', 'store', 'update']);
Route::middleware('auth')->group(function () {
    //SUBSCRIBE
    Route::post('/subscribe', [SubscribeController::class, 'subscribe'])->name('subscribe');
    Route::post('/like-comment', [LikeController::class, 'likeComment'])->name('posts.comments.like');
    //LIKES
    Route::post('/like-post', [LikeController::class, 'likePost'])->name('posts.like');
    //CLAIM STORE
    Route::post('/posts/{post}/claims', [AdminClaimController::class, 'store'])->name('posts.claims.store');
    //VIEW
    Route::post('/posts/{post:slug}/increment-views', [PostController::class, 'incrementViews'])->name('posts.incrementViews');
});


//ADMIN_PANEL
Route::name('admin.')->prefix('admin')->middleware(['role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles_and_permissions.index');
    Route::resource('roles', RoleController::class)->only(['store', 'destroy']);
    Route::resource('permissions', PermissionController::class)->only(['store', 'destroy']);
    //UPDATE ROLE FOR USER
    Route::post('/users/{user}/update-role', [AdminUserController::class, 'userRoleUpdate'])->name('users.role.update');
    //UPDATE PERMISSION FOR ROLE
    Route::put('/roles/{role}/permissions', [AdminUserController::class, 'rolePermissionUpdate'])->name('roles.permissions.update');
    //Users
    Route::resource('users', AdminUserController::class);
    Route::put('/users/{user}/update-status', [AdminUserController::class, 'updateUserStatus'])->name('users.status.update');
    //CATEGORY
    Route::resource('categories', AdminCategoryController::class);
    //POSTS
    Route::resource('posts', AdminPostController::class);
    Route::put('/posts/{post}/update-status', [AdminPostController::class, 'update_status'])->name('posts.update.status');
    //COMMENTS
    Route::resource('comments', AdminCommentController::class);
    //CLAIMS
    Route::resource('claims', AdminClaimController::class);
});


////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::fallback(fn() => view('error.error'));



