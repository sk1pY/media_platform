<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
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
use App\Http\Controllers\admin\ClaimController as AdminClaimController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;



//PROFILE
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/',[UserController::class,'index'])->name('index');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::get('/posts',[PostController::class,'profilePosts'])->name('posts');
    Route::get('/comments', [CommentController::class, 'comments'])->name('comments.index');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    //BOOKMARKS
    Route::resource('bookmarks', BookmarkController::class)->only(['index', 'store', 'destroy']);
    //subscriptions
    Route::get('/subscriptions', [SubscribeController::class, 'index'])->name('subscriptions.index');
    Route::get('/hidden-posts', [PostController::class, 'hidden_posts'])->name('hiddenPosts');

});

Route::post('/subscribe', [SubscribeController::class, 'subscribe'])->name('subscribe');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');


//CATEGORIES
Route::get('/categories-special/{slug}',[CategoryController::class,'specialCategories'])->whereIn('slug', ['popular', 'fresh', 'myFeed'])->name('specialCategories.show');
Route::prefix('categories')->name('categories.')
    ->group(function () {
        Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('show');
        Route::get('/my_feed', [CategoryController::class, 'my_feed'])->name('my_feed');
        Route::get('/newest', [CategoryController::class, 'newest'])->name('newest');
        Route::get('/popular', [CategoryController::class, 'popular'])->name('popular');
    });

//POSTS
Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::resource('posts', PostController::class)->only(['store', 'destroy','update']);
Route::post('posts/{post}/hide', [PostController::class, 'hide'])->name('posts.hide');



//COMMENTARIES
Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
Route::post('/like-comment', [CommentController::class, 'likeComment'])->name('like_comment');


//LIKES
Route::post('/like-post', [LikeController::class, 'like'])->name('posts.like');

//SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//VIEW
Route::post('/posts/{post:slug}/increment-views', [PostController::class, 'incrementViews'])->name('posts.incrementViews');

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
    Route::resource('claims', AdminClaimController::class);
});




////////////////////////////////////////////////////////////////////////////////////////////////////////
//Route::fallback(function(){
//   return view('error.error');
//});



