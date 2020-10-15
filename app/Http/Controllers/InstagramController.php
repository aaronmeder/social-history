<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function index()
    {

        // get data
        $likes = $this->get_likes()['likes'];
        $comments = $this->get_comments()['comments'];
        $comments_contacts = $this->get_comments()['contacts'];
        $general = $this->get_general_info();

        return view( 'instagram', compact('likes', 'comments', 'comments_contacts', 'general') );
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

    private function get_comments()
    {
        $json_file = storage_path('app/social-archives/instagram/comments.json');
        $json_data = json_decode( file_get_contents($json_file), true );
        $comments = collect( $json_data )['media_comments'];

        $optimised_comments = [];
        $contacts = [];
        foreach( $comments as $comment ) {
            $date_from_string = strtotime(explode("T",$comment[0])[0]);
            $date = $comment[0] ? date('d.m.Y', $date_from_string) : null;
            $text = $comment[1] ?? null;
            $contact = $comment[2];
            $contacts[] = $contact;

            $optimised_comments[] = compact('date', 'text', 'contact');
        }

        // optimise data
        $comments_counts = array_count_values($contacts);
        arsort($comments_counts);

        return [
            'comments' => $optimised_comments,
            'contacts' => $comments_counts
        ];
    }

    private function get_general_info() 
    {
        // profile
        $json_file = storage_path('app/social-archives/instagram/profile.json');
        $json_data = json_decode( file_get_contents($json_file), true );
        $profile = collect($json_data);

        // optimize data format
        $join_date_from_string = strtotime(explode("T",$profile['date_joined'])[0]);
        $join_date = $profile['date_joined'] ? date('d.m.Y', $join_date_from_string) : null;

        $general['registration_date'] = $join_date;

        return $general;
    }

}
