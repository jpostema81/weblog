@extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Message Show</a></li>
        </ul>
    </nav>

@endsection

@section('content')

    <div class="column is-8 is-offset-2">
        <p class="title article-title">
            {{ $message->title }}
        </p>
        <div class="tags has-addons">
            <span class="tag is-rounded is-info">@ {{ $message->user->name }}</span>
            <span class="tag is-rounded">{{ Carbon\Carbon::parse($message->created_at)->format('d-m-Y H:i') }}</span>
        </div>

        <div class="content article-body">
            {{ $message->content }}
        </div>

        @foreach ($message->comments as $comment)
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                    <img src="https://bulma.io/images/placeholders/128x128.png">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            {{ $comment->content }}
                            <!-- <small><a>Like</a> · <a>Reply</a> · 3 hrs</small> -->
                        </p>
                    </div>
                </div>
            </article>

        @endforeach

@endsection
