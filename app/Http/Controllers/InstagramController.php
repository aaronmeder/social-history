<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function index()
    {

        // get data
        $likes = $this->get_likes()['likes'];
        $likes_contacts = $this->get_likes()['contacts'];
        $comments = $this->get_comments()['comments'];
        $comments_contacts = $this->get_comments()['contacts'];
        $general = $this->get_general_info();
        $connections = $this->get_connections();

        return view( 'instagram', compact('likes', 'likes_contacts', 'comments', 'comments_contacts', 'general', 'connections') );
    }

    private function get_likes() 
    {
        $json_file = storage_path('app/social-archives/instagram/likes.json');
        $json_data = json_decode( file_get_contents($json_file), true );
        $likes = collect( $json_data['media_likes'] );

        $optimised_likes = [];
        $contacts = [];
        foreach($likes as $like) {

            $date_from_string = strtotime(explode("T",$like[0])[0]);
            $date = $like[0] ? date('d.m.Y', $date_from_string) : null;
            $contact = $like[1] ?? null;
            
            // extract the contact
            $contacts[] = $contact;

            // save like data
            $optimised_likes[] = compact('date', 'contact');

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

    private function get_connections() 
    {
        $json_file = storage_path('app/social-archives/instagram/connections.json');
        $json_data = json_decode( file_get_contents($json_file), true );
        $connections = collect($json_data);

        return $connections;
    }

}
