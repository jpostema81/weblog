@extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('blogposts.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Blogposts Overview</a></li>
        </ul>
    </nav>

@endsection

@section('content')

    <section class="articles">
        <div class="column is-8 is-offset-2">

            @foreach ($posts as $post)
                <div class="card article">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content has-text-centered">
                                <p class="title article-title">
                                    <a href="{{ route('blogposts.show', ['blogpost' => $post->id]) }}">{{ $post->title }}</a>
                                </p>
                                <div class="tags has-addons level-item">
                                    <span class="tag is-rounded is-info">@ {{ $post->user->name }}</span>
                                    <span class="tag is-rounded">{{ Carbon\Carbon::parse($post->created_at)->format('d-m-Y H:i') }}</span>
                                    <!-- $post->created_at -->
                                </div>
                            </div>
                        </div>
                        <div class="content article-body">
                            {{ $post->content }}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    
@endsection
