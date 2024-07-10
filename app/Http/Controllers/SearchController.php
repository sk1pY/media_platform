<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $posts = Task::where('title', 'LIKE', '%' . $request->search . "%")->get();

            if ($posts->count() > 0) {
                foreach ($posts as $post) {
                    $output .= '<a class=" link-secondary text-decoration-none text-dark" href="'.route('task.about',$post->id). '"><li class="list-group-item ">'.$post->title.'</li></a>';
                }
            } else {
                $output = '<li class="list-group-item">No results found</li>';
            }
            return response($output);
        }
    }

}
