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
        <a href="{{ route('admin.users.index') }}" class="button is-text is-pulled-right">Users overview</a>
        <a href="{{ route('admin.roles.index') }}" class="button is-text is-pulled-right">Roles overview</a></h1>

        <a href="{{ route('admin.permissions.create') }}" class="button is-primary">Create new permission</a>

        <br><br>
        
        <table class="table">
            <thead>
                <th>Permission</th>
                <th>Operations</th>
            </thead>

            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="button is-primary" style="margin-right: 3px;">Edit</a>
                        <a onclick="detelePermission({{ $permission->id }})" class="button is-danger" style="margin-right: 3px;">Delete</a>
                    </td>
                </tr></a>
                @endforeach
            </tbody>

        </table>
    </section>

@endsection
