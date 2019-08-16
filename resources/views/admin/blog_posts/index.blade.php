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
    <div class="columns">
        <div class="column is-8 is-offset-2">

            <a href="{{ route('admin.blogposts.create') }}" class="button is-primary">Write new blogpost</a>
            
            <table class="table">
                <thead>
                    <th>Title</th>
                    <th>Created at</th>
                    <th></th>
                    <th></th>
                </thead>

            @foreach ($posts as $post)
            <tr>
                <td><a href="#">{{ $post->title }}</td>
                <td>{{ Carbon\Carbon::parse($post->created_at)->format('d-m-Y H:i') }}</td>
                <td><a href="{{ route('admin.blogposts.edit', $post) }}">edit</a></td>
                <td><a href="#">delete</a></td>
            </tr></a>
            @endforeach

            </table>
        </div>
    </div>

@endsection
