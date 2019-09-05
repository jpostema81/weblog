@extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Permissions Overview</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    <section>
        <a href="{{ route('admin.users.index') }}" class="btn btn-default pull-right">Users overview</a>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-default pull-right">Roles overview</a></h1>

        <a href="{{ route('admin.roles.create') }}" class="button is-primary">Create new role</a>

        <br><br>
        
        <table class="table">
            <thead>
                <th>Permission</th>
                <th>Operation</th>
            </thead>

            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td><a href="{{ route('admin.permissions.edit', $permission) }}">edit</a></td>
                    <td><a onclick="detelePermission({{ $permission->id }})">delete</a></td>
                </tr></a>
                @endforeach
            </tbody>

        </table>
    </section>

@endsection
