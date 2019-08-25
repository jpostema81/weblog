@extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Messages Overview</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    <section>
        <a href="{{ route('admin.messages.create') }}" class="button is-primary">Write new message</a>

        <br><br>
        
        <table class="table">
            <thead>
                <th>Title</th>
                <th>Created at</th>
                <th></th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($messages as $message)
                <tr>
                    <td><a href="{{ route('messages.show', ['message' => $message->id]) }}">{{ $message->title }}</td>
                    <td>{{ Carbon\Carbon::parse($message->created_at)->format('d-m-Y H:i') }}</td>
                    <td><a href="{{ route('admin.messages.edit', $message) }}">edit</a></td>
                    <td><a onclick="deteleMessage({{ $message->id }})">delete</a></td>
                </tr></a>
                @endforeach
            </tbody>

        </table>
    </section>

@endsection
