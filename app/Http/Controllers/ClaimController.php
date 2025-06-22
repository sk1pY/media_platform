<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClaimStoreRequest;
use App\Models\Claim;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    public function __invoke(ClaimStoreRequest $request, Post $post): RedirectResponse
    {

        Claim::create([
            'title' => $request->validated('title'),
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'status' => 'На рассмотрении',
        ]);

        return back()->with('success', 'жалоба отправлена');
    }
}
