<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class SubscribeController extends Controller
{

    public function index(){
        $subscriptions = Subscribe::where('user_id', Auth::id())->pluck('author_id')->toArray();
        $authors = User::whereIn('id', $subscriptions)->get();

        return view('dashboard.subscriptions', compact('authors'));
    }
        public function add(Request $request){
            $author_id = $request->input('sub_id');
            $user_id = Auth::id();
            $sub = Subscribe::where('author_id',$author_id)->where('user_id',$user_id)->first();
            $subAuthors = Subscribe::where('user_id', Auth::id())->pluck('author_id')->toArray();

            // dd($sub);
            if($sub){
                $sub->delete();
                return response()->json(['subAuthors'=>$subAuthors,'success' => true, 'sub' => false]);

            }
                $sub =  Subscribe::create(['author_id' => $author_id, 'user_id' => $user_id]);
            return response()->json(['subAuthors'=>$subAuthors,'success' => true, 'sub' => true]);


        }
}
