<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\HiddenPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::get();
        $postQuery = Post::where('status', 1)->withCount(['comments', 'likes'])->orderBy('created_at','desc');

        if (Auth::check()) {
            $hiddenPostIds = HiddenPost::where(['user_id' => Auth::id()])->pluck('post_id')->toArray();
            $postQuery->wherenotin('id', $hiddenPostIds);
        }

        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'popular':
                    $postQuery->orderBy('views', 'desc');
                    break;
                case 'recent':
                    $postQuery->orderBy('created_at', 'desc');
                    break;
                case 'old':
                    $postQuery->orderBy('created_at', 'asc');
            }
        }

        $posts = $postQuery->paginate(5);
        return view('index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:500',
            'image' => 'image|mimes:jpg,png,jpeg',
            'cat_name' => 'nullable'
        ]);

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
        try {
            $user = User::find(Auth::id());
            $user->posts()->create(
                array_merge(
                    $validated,
                    ['image' => $fileName, 'category_id' => $category_id]
                )
            );
        } catch (\Exception $e) {
            Log::error('Ошибка при создании поста: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Произошла ошибка при создании поста.');
        }

        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,Po $post)
    {
        if (!$post->status ) {
            abort(404, 'error.error');
        }

        $comments = Comment::where('post_id', $post->id)->orderBy('created_at', 'desc')->get();

        $post = Post::withCount(['comments', 'likes'])->find($post->id);
        if ($request->filled('filter_comments')) {
            $query = Comment::query();

            switch (request('filter_comments')) {

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update',$post);

        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('postImages', 'public');
            $fileName = basename($path);
            $validatedData['image'] = $fileName;
        } else {
            unset($validatedData['image']);
        }
        $post->update(array_merge($validatedData, ['user_id' => Auth::id()]));

        return redirect()->route('home.profile.show',Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('destroy',$post);

        $post->delete();
        return redirect()->back();
    }


//    ----------------------------------------------------------------------------------

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
    public function hidden_posts()
    {
        $postsIds = HiddenPost::where(['user_id' => Auth::id()])->pluck('post_id');
        $posts = Post::whereIn('id', $postsIds)->withCount(['comments', 'likes'])->get();
        return view('right_sidebar.hiddenPosts_show', compact('posts'));
    }

    public function incrementViews(Post $post)
    {
        $post->query()->increment('views');
        return response()->json(['views' => $post->views]);
    }
}
