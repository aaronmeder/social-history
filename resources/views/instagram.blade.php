@extends('layouts.app')
@section('body-class', 'social-profile instagram')

@section('content')

    <div class="site-grid">
    
        <section>
        
            <header>
                <h1>My Profile</h1>
                <ul>
                    <li>Registration date: {{ $general['registration_date'] }}</li>
                    <li>Followers: {{ count($connections['followers']) }}</li>
                    <li>Following: {{ count($connections['following']) }}</li>
                    <li>Close Friends: {{ count($connections['close_friends']) }}</li>
                </ul>
            </header>

        </section>

        <section>

            <header>
                <h1>Comments</h1>
                Total Comments I made: {{ count($comments) }}
            </header>

            <article>
                <h2>I commented the most on posts by</h2>
                <ul>
                    @foreach( array_slice($comments_contacts,0,10) as $contact => $comment_count )
                        <li><strong>{{ utf8_decode($contact) }}</strong> {{ $comment_count }}</li>
                    @endforeach
                </ul>
            </article>

        </section> 

        <section>

            <header>
                <h1>Likes</h1>
                Total Likes: {{ count($likes) }}
            </header>

            <article>
                <h2>The most posts I liked were by</h2>
                <ul>
                    @foreach( array_slice($likes_contacts,0,9) as $name => $like_count )
                        <li><strong>{{ utf8_decode($name) }}</strong> {{ $like_count }}</li>
                    @endforeach
                </ul>
            </article>

        </section>
        
        <section>
        
            <header>
                <h1>Connections</h1>
            </header>

            <article>
                <h2>I first followed</h2>
                <ul>
                @foreach( array_slice($oldest_following,0,9) as $name => $date )
                    <li>
                        {{ $name }}
                    </li>
                @endforeach
                <ul>
            </article>
        
        </section>

        <section>
        
            <header>
                <h1>My media</h1>
            </header>

            <article>
                <ul>
                    <li><strong>Photos uploaded: </strong> {{ count($media['photos']) }}</li>
                    <li><strong>Stories created: </strong> {{ count($media['stories']) }}</li>
                    <li><strong>Videos uploaded: </strong> {{ count($media['videos']) }}</li>
                </ul>   
            </article>
        
        </section>

        <section>
        
            <header>
                <h1>Tags</h1>
            </header>

            <article>
                <h2>Most often tagged</h2>
                <ul>
                    @foreach( array_slice($tags,0,5) as $title => $count )
                        <li>
                            <strong>{{ $title }}</strong> {{ $count }}
                        </li>
                    @endforeach
                <ul>     
            </article>
        
        </section>

    </div> <!-- end site-content -->

@endsection