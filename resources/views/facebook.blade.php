@extends('layouts.app')
@section('body-class', 'social-profile facebook')

@section('content')

    <div class="site-grid">
    
        <section>
        
            <header>
                <h1>Profile</h1>
                Registration date: {{ $general['registration_date'] }}
            </header>

        </section>
        
        <section>
        
            <header>
                <h1>Posts</h1>
                Total Posts: {{ count($posts) }}
            </header>

        </section>

        <section>
        
            <header>
                <h1>Friends</h1>
                Total Friends: {{ count($friends) }}
            </header>

            @foreach( array_slice($friends,0,9) as $friend )
                <article>
                    <strong>{{ utf8_decode($friend['name']) }}</strong> 
                    {{ $friend['date'] }}
                </article>
            @endforeach

        </section>

        <section>

            <header>
                <h1>Likes</h1>
                Total Likes: {{ count($likes) }}
            </header>

            <article>
                <h2>Top Ten Interactions</h2>
                <ul>
                    @foreach( array_slice($likes_contacts,0,9) as $name => $like_count )
                        <li><strong>{{ utf8_decode($name) }}</strong> {{ $like_count }}</li>
                    @endforeach
                </ul>
            </article>

        </section>

        <section>

            <header>
                <h1>Comments</h1>
                Total Comments: {{ count($comments) }}
            </header>

            <article>
                <h2>Top Ten Interactions</h2>
                <ul>
                    @foreach( array_slice($comments_contacts,0,9) as $contact => $comment_count )
                        <li><strong>{{ utf8_decode($contact) }}</strong> {{ $comment_count }}</li>
                    @endforeach
                </ul>
            </article>

        </section>

    </div> <!-- end site-content -->

@endsection