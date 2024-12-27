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
    public function index(Request $request)
    {
        $categories = Category::get();
//        $posts = Post::withCount(['comments', 'likes'])->orderBy('created_at', 'DESC')->get();

        $query = Post::withCount(['comments', 'likes']);
        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'popular':
                    $query->withCount(['comments', 'likes'])->orderBy('comments_count', 'desc');
                    break;
                case 'recent':
                    $query->withCount(['comments', 'likes'])->orderBy('created_at', 'desc');
                    break;
                case 'old':
                    $query->withCount(['comments', 'likes'])->orderBy('created_at', 'asc');
            }
        }

        $posts = $query->get();

        return view('index', compact('posts', 'categories'));
    }

    public function categories(Category $category)
    {

        $posts = $category->posts()->orderBy('created_at', 'DESC')->withCount(['comments', 'likes'])->get();

        return view('category', compact('posts', 'category'));
    }

    public function post(Post $post)
    {

//        if ($post == null) {
//            abort(404, 'error');
//        }
        $post = $post->withCount(['comments', 'likes'])->find($post->id);
        $comments = Comment::where('post_id', $post->id)->orderBy('created_at', 'desc')->get();

        return view('about_task', compact('post', 'comments'));
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
        $authors_ids = Subscribe::where('subscriber_id', Auth::id())->pluck('author_id');

        $posts = Post::whereIn('user_id', $authors_ids)->withCount(['comments', 'likes'])->get();

        return view('myfeed', compact('posts'));
    }

    public function incrementViews(Post $post)
    {

        $post->increment('views');
        return response()->json(['views' => $post->views]);
    }

    public function error()
    {
        return 'eror';

    }


}
