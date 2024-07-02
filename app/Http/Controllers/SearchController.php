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
                    $output .= '<li class="list-group-item "><a class=" link-secondary text-decoration-none text-dark" href="'.route('about_task',$post->id). '">'.$post->title.'</a></li>';
                }
            } else {
                $output = '<li class="list-group-item">No results found</li>';
            }
            return response($output);
        }
    }

}
