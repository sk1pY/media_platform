<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
        public function add(Request $request){
            $author_id = $request->input('sub_id');
            $sub_id = Auth::id();
            $sub = Subscribe::where('author_id',$author_id)->where('subscriber_id',$sub_id)->first();
           // dd($sub);
            if($sub){
                $sub->delete();
                return response()->json(['success' => true, 'sub' => false]);

            }
                $sub =  Subscribe::create(['author_id' => $author_id, 'subscriber_id' => $sub_id]);
            return response()->json(['success' => true, 'sub' => true]);


        }
}
