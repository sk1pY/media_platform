<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = ["Ожидает рассмотрения", "Принято", "Отклонено"];
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
    public function store()
    {

       //
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
        // Log::info($request->input('status'));
        if ($request['status'] === 'Принято') {
            $post = Post::find($claim->post_id);
            $post->status = 0;
            $post->save();

        } elseif ($request['status'] === 'Отклонено') {
            $post = Post::find($claim->post_id);
            $post->status = 1;
            $post->save();
        }

        $claim->update([
            'status' => $request['status']
        ]);

        return response()->json(['success' => 'success update status']);

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
