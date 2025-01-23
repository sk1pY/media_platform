<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\HiddenPost;
use App\Models\Subscribe;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;


class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::get();
        $posts = Post::where('status', 1)->withCount(['comments', 'likes'])->get();


        if (Auth::check()) {

            $postIds = $posts->pluck('id')->toArray();
            $hiddenPostIds = HiddenPost::where(['user_id' => Auth::id()])->pluck('post_id')->toArray();

            $resultArrayIds = collect($postIds)->reject(function ($value) use ($hiddenPostIds) {
                return in_array($value, $hiddenPostIds);
            })->all();
            $posts = Post::whereIn('id', $resultArrayIds)->where('status', 1)->get();
            $postsForFilters = Post::whereIn('id', $resultArrayIds)->where('status', 1);

        }else{
            $postsForFilters = Post::where('status', 1)->withCount(['comments', 'likes']);
        }


        if ($request->filled('filter')) {

            switch ($request->input('filter')) {
                case 'popular':
                    $postsForFilters->orderBy('views', 'desc');
                    break;
                case 'recent':
                    $postsForFilters->orderBy('created_at', 'desc');
                    break;
                case 'old':
                    $postsForFilters->orderBy('created_at', 'asc');
            }
            $posts = $postsForFilters->get();
        }


        return view('index', compact('posts', 'categories'));
    }

    public function categories(Category $category)
    {

        $posts = $category->posts()->orderBy('created_at', 'DESC')->withCount(['comments', 'likes'])->get();

        return view('category', compact('posts', 'category'));
    }

    public function post(Request $request, Post $post)
    {
//        if ($post == null) {
//            abort(404, 'error');
//        }
        $comments = Comment::where('post_id', $post->id)->orderBy('created_at', 'desc')->get();

        $post = Post::withCount(['comments', 'likes'])->find($post->id);
        if ($request->filled('filter_comments')) {
            $query = Comment::query();

            switch ($request->input('filter_comments')) {
//                  case 'popular':
//                      $query->orderBy('created_at', 'desc');
//                      break;
                case 'recent':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'old':
                    $query->orderBy('created_at', 'asc');
            }
            $comments = $query->get();

        }


        return view('about_task', compact('post', 'comments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:500',
            'image' => 'image|mimes:jpg,png,jpeg',
            'cat_name' => 'nullable'
        ],);

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('postImages', 'public');
            $fileName = basename($path);
        } else {
            $localPath = public_path('default_images/default.png');
            $newPath = Storage::disk('public')->putFile('postImages', $localPath);


            $fileName = basename($newPath);
        }

        $category_id = null;

        if (!empty($validated['cat_name'])) {
            $category_obj = Category::where('name', $validated['cat_name'])->first();
            $category_id = $category_obj->id;
        }

        Auth::user()->posts()->create(array_merge(
                $validated,
                ['image' => $fileName, 'category_id' => $category_id])
        );


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

    public function newest()
    {

        $posts = Post::where('created_at', '>=', Carbon::now()->subDay())
            ->withCount(['comments', 'likes'])->get();

        return view('myfeed', compact('posts'));
    }

    public function popular()
    {

        $posts = Post::orderBy('views', 'DESC')->withCount(['comments', 'likes'])->get();

        return view('popular', compact('posts'));
    }

    public function incrementViews(Post $post)
    {

        $post->increment('views');
        return response()->json(['views' => $post->views]);
    }


    public function hide(Request $request, Post $post)
    {

        if ($request['hidden']) {
            $hiddenPost = HiddenPost::where(['user_id' => Auth::id(), 'post_id' => $post->id])->first();
            if ($hiddenPost) {
                $post->hiddenPosts()->detach(Auth::id());
            } else {
                $post->hiddenPosts()->attach(Auth::id());
            }
        }
        return redirect()->route('index');
    }

    public function invitations(Request $request, $invitation, $answer)
    {
        if ($answer === 'yes') {
            return response()->json([
                'message' => 'Спасибо за принятие приглашения!',
                'invitation_id' => $invitation,
            ]);
        } else {
            return response()->json([
                'message' => 'Вы отклонили приглашение.',
                'invitation_id' => $invitation,
            ]);
        }


    }
}
