@extends('layouts.master')

@section('title', 'Jeroen\'s weblog')
<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('content')
    <section class="articles">
        <div class="column is-8 is-offset-2">

            @foreach ($posts as $post)
                <div class="card article">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content has-text-centered">
                                <p class="title article-title">{{ $post->title }}</p>
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
