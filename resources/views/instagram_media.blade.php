@extends('layouts.app')
@section('body-class', 'instagram-media')

@section('content')

    <div class="site-grid">
    
        <section>
        
            <header>
                <h1>My Media</h1>
            </header>

            <article class="instas">
                <nav class="instas__filters">
                    @foreach ( $tags_nav as $item_label => $item_tag )
                        <a class="media-filter" href="#" data-filter="{{ $item_tag }}">#{{ $item_label }}</a>
                    @endforeach
                </nav>
                <ul class="instas__media media-grid">
                    @foreach ( $media['photos'] as $single )
                        <li class="instas__single media-single {{ $single['class'] }}">
                            <img
                                src="/media/instagram/{{ $single['path'] }}"
                                loading="lazy"
                                title="{{ $single['title'] }}"
                            />
                        </li>
                    @endforeach
                </ul>
            </article>

        </section>

    </div> <!-- end site-content -->

@endsection