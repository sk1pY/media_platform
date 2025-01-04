<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(6);
        return view('admin.category', compact('categories'));
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
        $validated = $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('categoryImages', 'public');
            $fileName = basename($path);
        }

        Category::create([
            'name' => $request['name'],
            'image' => $fileName,
        ]);
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Category $category)
    {


        $validated = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);


        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete('categoryImages/' . $category->image);
            }
            $path = $request->file('image')->store('categoryImages', 'public');
            $fileName = basename($path);
            $validated['image'] = $fileName;
        } else {
            $validated['image'] = $category->image;
        }

          $category->update([
            'name' => $request['name'],
            'image' => $validated['image'],
        ]);


        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
