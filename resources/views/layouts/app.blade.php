<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

    </head>
    <body>

        <header>
            <nav>
                <ul>
                    <li><a href="{{ route('facebook') }}">Facebook</a></li>
                </ul>
            </nav>
        </header>

        @yield('content')
        
    </body>
</html>
