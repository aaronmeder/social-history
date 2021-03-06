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
        $connections = $this->get_connections()['connections'];
        $oldest_following = $this->get_connections()['oldest_following'];
        $media = $this->get_media()['media'];
        $tags = $this->get_media()['tags_count'];
        $tags_nav = $this->get_media()['tags_nav'];

        return view( 'instagram', compact('likes', 'likes_contacts', 'comments', 'comments_contacts', 'general', 'connections', 'oldest_following', 'media', 'tags', 'tags_nav') );
    }

    public function list_media()
    {
        $media = $this->get_media()['media'];
        $tags_nav = $this->get_media()['tags_nav'];


        return view( 'instagram_media', compact('media', 'tags_nav') );
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

        $oldest_following = $connections['following'];
        asort($oldest_following);

        return [
            'connections' => $connections,
            'oldest_following' => $oldest_following
        ];
    }

    private function get_media() 
    {
        // get data
        $json_file = storage_path('app/social-archives/instagram/media.json');
        $json_data = json_decode( file_get_contents($json_file), true );
        //$media = collect($json_data);
        $media = $json_data;

        // get tags and mentions in photo captions
        $tags = [];
        $tags_nav = [];
        $mentions = [];
        foreach( $media['photos'] as $key => $photo ) {

            $this_photo_tags = "";

            // get tags
            preg_match('/(#\w+)/', $photo['caption'], $found_tags);
            if($found_tags) {
                array_push($tags, $found_tags[0]);
                $this_photo_tags .= $found_tags[0] . " ";
            }

            // get mentions
            preg_match('/(@\w+)/', $photo['caption'], $found_mentions);
            if($found_mentions) {
                array_push($mentions, $found_mentions[0]);
            }

            // save found tags for image class
            $media['photos'][$key]['class'] = str_replace( '#', 'tag-', $this_photo_tags );
            
            // save found tags for tag nav
            $separated_tags = explode( " ", $this_photo_tags );
            foreach( $separated_tags as $tag ) {
                $tag_text = str_replace( '#', '', $tag );
                if( !array_key_exists( $tag_text , $tags_nav ) ) {
                    $tags_nav[$tag_text] = 'tag-' . $tag_text;
                }
            }

            // save title 
            $location_text = array_key_exists('location', $photo) ? " @ " . $photo['location'] : ""; 
            $media['photos'][$key]['title'] = $photo['caption'] . "\n--\nTaken: " . $photo['taken_at'] . $location_text; 
            
        }

        // optimize data
        $tags_count = array_count_values($tags);
        arsort($tags_count);

        $mentions_count = array_count_values($mentions);
        arsort($mentions_count);

        return [
            'media' => $media,
            'tags_count' => $tags_count,
            'tags_nav' => $tags_nav,
            'mentions_count' => $mentions_count
        ];
    }

}
