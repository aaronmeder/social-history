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
            </header>

        </section>

    </div> <!-- end site-content -->

@endsection