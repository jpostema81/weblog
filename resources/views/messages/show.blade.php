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

    @foreach ($message->descendants as $comment)
    
        <article class="media">
            <figure class="media-left">
                <p class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png">
                </p>
            </figure>
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>{{ $comment->user->name }}</strong>
                        <br>
                        {{ $comment->content }}
                        <br>
                        <small><a>Reply</a> · {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                    </p>
                </div>
            </div>
        </article>

    @endforeach

    <br>

    @auth
    {{ Form::model($message, ['route' => ['comments.store', $message->id], 'method' => 'POST']) }}
    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">
            <img src="https://bulma.io/images/placeholders/128x128.png">
            </p>
        </figure>
        <div class="media-content">
            <div class="field">
            <p class="control">
                {{ Form::textarea('comment', null, array('class' => 'textarea', 'rows' => '4', 'placeholder' => 'Add a comment...')) }}
            </p>
            </div>
            <div class="field">
            <p class="control">
                {{ Form::submit("Post comment", array('class' => 'button')) }}
            </p>
            </div>
        </div>
    </article>
    {{ Form::close() }}
    @endauth

@endsection
