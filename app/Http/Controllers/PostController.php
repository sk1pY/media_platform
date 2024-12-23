<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {

        $categories = Category::get();
        //сумма лайков и коментов WithCount(*****)
        $posts = Post::withCount(['comments', 'likes'])->orderBy('created_at', 'DESC')->get();
        $likedPostUser = Like::where('user_id', Auth::id())->pluck('post_id')->toArray();
        $bookmarkPostUser = Bookmark::where('user_id', Auth::id())->pluck('post_id')->toArray();
        $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();

        return view('index', compact('posts', 'categories', 'likedPostUser', 'bookmarkPostUser', 'subAuthors'));
    }

    public function categories(Category $category)
    {
        $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();

        $likedPostUser = Like::where('user_id', Auth::id())->pluck('post_id')->toArray();
        $bookmarkPostUser = Bookmark::where('user_id', Auth::id())->pluck('post_id')->toArray();

        $posts = $category->posts()->orderBy('created_at', 'DESC')->get();

        return view('category', compact('posts','likedPostUser','bookmarkPostUser','subAuthors','category'));
    }

    public function post($id)
    {
        $likedPostUser = Like::where('user_id', Auth::id())->pluck('post_id')->toArray();
        $bookmarkPostUser = Bookmark::where('user_id', Auth::id())->pluck('post_id')->toArray();

        $post = Post::where('id', $id)->withCount(['comments', 'likes'])->first();

        if ($post == null) {
            abort(404, 'error');
        }

        $comments = Comment::where('post_id', $id)->orderBy('created_at', 'desc')->get();
        return view('about_task', compact('post', 'comments', 'likedPostUser', 'bookmarkPostUser'));
    }

    private const BB_VALIDATOR = [
        'title' => 'required|max:250',
        'description' => 'required',
        //  'image' => 'nullable|image|mimes:jpg,png,jpeg,gif',
        'cat_name' => 'nullable'
    ];

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('postImages', 'public');
            $fileName = basename($path);
        }

        $validated = $request->validate(self::BB_VALIDATOR);
        $category_id = null;

        if (!empty($validated['cat_name'])) {
            $category_obj = Category::where('name', $validated['cat_name'])->first();
            $category_id = $category_obj->id;
        }

        Auth::user()->posts()->create(['title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $category_id,
            'image' => $fileName
        ]);


        return redirect()->route('index');
    }


    public function delete($id)
    {
        Post::find($id)->delete();
        return redirect()->route('home');
    }

    public function update($id)
    {
        $post = Post::findOrFail($id);

        Post::update(['title' => true]);
        return redirect()->route('index',
            $post->id);

    }

    public function my_feed()
    {
        $likedPostUser = Like::where('user_id', Auth::id())->pluck('post_id')->toArray();
        $bookmarkPostUser = Bookmark::where('user_id', Auth::id())->pluck('post_id')->toArray();
        $subAuthors = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id')->toArray();

        $authors_ids = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id');

        $posts = Post::whereIn('user_id', $authors_ids)->withCount(['comments', 'likes'])->get();

        return view('myfeed', compact('posts', 'likedPostUser', 'bookmarkPostUser', 'subAuthors'));
    }

    public function error()
    {
        return 'eror';

    }


}
