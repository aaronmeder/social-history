<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function index()
    {
        echo "facebook index";

        $posts_json = storage_path('app/social-archives/facebook/posts/your_posts_1.json');
        $posts = collect( json_decode( file_get_contents($posts_json), true ) );
        dd($posts);
    }
}
