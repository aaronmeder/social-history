@extends('layouts.app')
@section('body-class', 'social-profile facebook')

@section('content')

    <div class="site-grid">
    
        <section>
        
            <header>
                <h1>My Profile</h1>
                Registration date: {{ $general['registration_date'] }}
            </header>

        </section>

        <section>
        
            <header>
                <h1>Pages</h1>
                Total Pages I liked: {{ count($page_likes) }}
            </header>

            <article>
                <h2>First pages liked</h2>
                <ul>
                    @foreach( array_slice($page_likes,0,9) as $page )
                        <li>
                            {{ utf8_decode($page['name']) }}
                        </li>
                    @endforeach
                </ul>
            </article>

        </section>
        
        <section>
        
            <header>
                <h1>Posts</h1>
                Total Posts I've made: {{ count($posts) }}
            </header>

        </section>

        <section>
        
            <header>
                <h1>Friends</h1>
                Total friends I connected with: {{ count($friends) }}
            </header>

            <article>
                <h2>First Friends</h2>
                <ul>
                @foreach( array_slice($friends,0,9) as $friend )
                    <li>
                        <strong>{{ utf8_decode($friend['name']) }}</strong> 
                        {{ $friend['date'] }}
                    </li>
                @endforeach
                <ul>
            </article>

        </section>

        <section>

            <header>
                <h1>Likes</h1>
                Total Likes I gave: {{ count($likes) }}
            </header>

            <article>
                <h2>Contacts I gave most likes</h2>
                <ul>
                    @foreach( array_slice($likes_contacts,0,9) as $name => $like_count )
                        <li><strong>{{ utf8_decode($name) }}</strong> {{ $like_count }}</li>
                    @endforeach
                </ul>
            </article>

        </section>

        <section>

            <header>
                <h1>My Comments</h1>
                Total Comments I made: {{ count($comments) }}
            </header>

            <article>
                <h2>Top people I made comments on</h2>
                <ul>
                    @foreach( array_slice($comments_contacts,0,9) as $contact => $comment_count )
                        <li><strong>{{ utf8_decode($contact) }}</strong> {{ $comment_count }}</li>
                    @endforeach
                </ul>
            </article>

        </section>

    </div> <!-- end site-content -->

@endsection