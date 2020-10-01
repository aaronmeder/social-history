@extends('layouts.app')
@section('body-class', 'social-profile facebook')

@section('content')

    <div class="site-content">
    
        <section>
        
            <header>
                <h1>Posts</h1>
                Total Posts: {{ count($posts) }}
            </header>

            @foreach ($posts as $post)
                <article>
                    <em>{{ $post['date'] }}</em>
                    {{ $post['title'] }}
                </article>
            @endforeach

        </section>

        <section>

            <header>
                <h1>Likes</h1>
                Total Likes: {{ count($likes) }}

                <article>
                    <h2>Top Ten Interactions</h2>
                    <ul>
                        @foreach( array_slice($likes_contacts,0,9) as $contact => $like_count )
                            <li><strong>{{ $contact }}</strong> {{ $like_count }}</li>
                        @endforeach
                    </ul>
                </article>
            </header>

        </section>

    </div> <!-- end site-content -->

@endsection