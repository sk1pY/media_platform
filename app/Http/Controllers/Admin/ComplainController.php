<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = ['Accepted', 'Deleted'];
        $complains = Complain::all();
        return view('admin.complains',compact('complains','statuses'));
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
        //dd($request->all());

        Complain::create([
            'name' => $request['name'],
            'user_id' => Auth::user()->id,
            'post_id' => $request['post_id'],
            'status' => 'accepted',
        ]);
        return redirect()->route('index');
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
    public function update(Request $request, Complain $complain)
    {
        if($request['status'] == 'Deleted'){
          $post =   Post::find($complain->post_id)->first();
            $post->status =  0;
            $post->save();
        }

            $complain->update([
                'status' => $request['status'],
            ]);

        return redirect()->route('admin.complains.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complain $complain)
    {
        $complain->delete();
        return redirect()->route('admin.complains.index');
    }
}
