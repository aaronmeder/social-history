<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function index()
    {

        $posts = $this->get_posts();
        $likes = $this->get_likes();

        dd($likes);

        return view( 'facebook', compact('posts', 'likes') );
    }

    private function get_likes() 
    {
        $json_file = storage_path('app/social-archives/facebook/likes_and_reactions/posts_and_comments.json');
        $json_data = json_decode( file_get_contents($json_file), true );
        $likes = collect( $json_data['reactions'] );

        $optimised_likes = [];
        $contacts = [];
        foreach($likes as $like) {

            $date = $like['timestamp'] ? date('d.m.Y', $like['timestamp']) : null;
            $title = $like['title'] ?? null;
            $type = $like['data'][0]['reaction']['reaction'];
            $contact = null;

            if ( $type == "LIKE") {
                $contact = str_replace("Aaron Meder likes ", "", $title);
                $contact = explode("'", $contact)[0];
                $contacts[] = $contact;
            }

            $optimised_likes[] = compact('date', 'type', 'contact');

        }

        $nr_contacts = array_count_values($contacts);
        arsort($nr_contacts);
        dd($nr_contacts);

        return $optimised_likes;
    }

    private function get_posts()
    {
        $json_file = storage_path('app/social-archives/facebook/posts/your_posts_1.json');
        $posts = collect( json_decode( file_get_contents($json_file), true ) );

        $optimised_posts = [];
        foreach($posts as $post) {
            $date = $post['timestamp'] ? date('d.m.Y', $post['timestamp']) : null;
            $title = $post['title'] ?? null;
            $optimised_posts[] = compact('date', 'title');
        }

        return $optimised_posts;
    }
}
