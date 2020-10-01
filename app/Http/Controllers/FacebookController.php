<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function index()
    {

        // get data
        $posts = $this->get_posts();
        $likes = $this->get_likes()['likes'];
        $likes_contacts = $this->get_likes()['contacts'];
        $comments = $this->get_comments()['comments'];
        $comments_contacts = $this->get_comments()['contacts'];

        return view( 'facebook', compact('posts', 'likes', 'likes_contacts', 'comments', 'comments_contacts') );
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
            
            // extract the contact
            $contact = str_replace("Aaron Meder likes ", "", $title);
            $contact = explode("'", $contact)[0];
            $contacts[] = $contact;

            $optimised_likes[] = compact('date', 'type', 'contact');

        }

        // optimise data
        $contacts_counts = array_count_values($contacts);
        arsort($contacts_counts);

        return [
            'likes' => $optimised_likes,
            'contacts' => $contacts_counts
        ];
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

    private function get_comments()
    {
        $json_file = storage_path('app/social-archives/facebook/comments/comments.json');
        $json_data = json_decode( file_get_contents($json_file), true );
        $comments = collect($json_data)['comments'];

        $optimised_comments = [];
        foreach($comments as $comment) {

            $date = $comment['timestamp'] ? date('d.m.Y', $comment['timestamp']) : null;
            $title = $comment['title'] ?? null;
            $optimised_comments[] = compact('date', 'title');

            // extract the contact
            $contact = str_replace("Aaron Meder commented on ", "", $title);
            $contact = str_replace("Aaron Meder replied to ", "", $contact);
            $contact = explode("'", $contact)[0];
            $contacts[] = $contact;

        }

        // optimise data
        $contacts_counts = array_count_values($contacts);
        arsort($contacts_counts);

        return [
            'comments' => $optimised_comments,
            'contacts' => $contacts_counts
        ];
    }

}
