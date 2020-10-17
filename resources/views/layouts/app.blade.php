
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">

        <link rel="stylesheet" type="text/css" href="css/index.css" />
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=Ubuntu+Mono&display=swap" rel="stylesheet"> 

        <title>{{ config('app.name') }}</title>

    </head>
    <body class="@yield('body-class')">

        <div class="site-wrapper">

                <header class="site-header">
                    <nav>
                        <ul>
                            <li><a href="/" class="logo">My Social History</a></li>
                            <li><a href="{{ route('facebook') }}">Facebook</a></li>
                            <li><a href="{{ route('instagram') }}">Instagram</a></li>
                        </ul>
                    </nav>
                </header>

                <div class="site-content">
                    @yield('content')
                </div>

        </div> <!-- end site-wrapper -->
        
    </body>
</html>
