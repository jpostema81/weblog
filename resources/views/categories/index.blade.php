@extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Categories Overview</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    <section>
        <a href="{{ route('categories.create') }}" class="button is-primary">Create new category</a>

        <br><br>
        
        <table class="table">
            <thead>
                <th>Name</th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td><a href="{{ route('categories.show', ['category' => $category->id]) }}">{{ $category->name }}</td>
                    <td><a href="#" onclick="deteleCategory({{ $category->id }})">delete</a></td>
                </tr></a>
                @endforeach
            </tbody>

        </table>
    </section>

@endsection
