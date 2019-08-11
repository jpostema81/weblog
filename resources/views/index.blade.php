<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Jeroen's Weblog</title>
    </head>
    <body>
        @foreach ($posts as $post)
            <div>
                <p><b>{{ $post->title }}</b></p>
                <p>{{ $post->content }}</p>
            </div>
        @endforeach

        <script src="/js/app.js"></script>
    </body>
</html>
