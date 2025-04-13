<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Complain;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = ['Pending', 'Accepted', 'Rejected'];
        $claims = Claim::get();
        return view('admin.claims', compact('claims', 'statuses'));
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
        $validate = $request->validate([
            'name' => 'required',
        ]);
        Claim::create([
            'title' => $request['name'],
            'user_id' => Auth::user()->id,
            'post_id' => $request['post_id'],
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
    public function update(Request $request, Claim $claim)
    {
        if ($request['status'] == 'Accepted') {
            $post = Post::find($claim->post_id);
            $post->status = 0;
            $post->save();

        }elseif($request['status'] == 'Rejected'){
            $post = Post::find($claim->post_id);
            $post->status = 1;
            $post->save();
        }

        $claim->update([
            'status' => $request['status']
        ]);

        return response()->json(['success' => 'succes update status']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->route('admin.claims.index');
    }
}
