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
        $categories = Category::latest()->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|alpha|unique:categories,name,' . $request['id'],
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $validate['image'] = $request->hasFile('image') ? basename($request->file('image')->store('categoryImages', 'public')) : null;

        Category::create($validate);
        return back()->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|alpha|unique:name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);


        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete('categoryImages/' . $category->image);
            }
            $validated['image'] = basename($request->file('image')->store('categoryImages', 'public'));
        } else {
            $validated['image'] = $category->image;
        }

        $category->update([$validated]);

        return back()->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }
}
