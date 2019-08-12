@extends('layouts.master')

@section('title', 'Jeroen\'s weblog')
<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('blogposts.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Blogposts Show</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    <div class="column is-8 is-offset-2">
        <p class="title article-title">
            {{ $blogpost->title }}
        </p>
        <div class="tags has-addons">
            <span class="tag is-rounded is-info">@ {{ $blogpost->user->name }}</span>
            <span class="tag is-rounded">{{ Carbon\Carbon::parse($blogpost->created_at)->format('d-m-Y H:i') }}</span>
        </div>

        <div class="content article-body">
            {{ $blogpost->content }}
        </div>
    </div>

@endsection
