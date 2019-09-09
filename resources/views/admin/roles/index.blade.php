@extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Roles Overview</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    <section>
        <a href="{{ route('admin.users.index') }}" class="button is-text is-pulled-right">Users overview</a>
        <a href="{{ route('admin.permissions.index') }}" class="button is-text is-pulled-right">Permissions overview</a></h1>

        <a href="{{ route('admin.roles.create') }}" class="button is-primary">Create new role</a>
        
        <br><br>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th colspan="2">Operations</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->permissions()->pluck('name')->implode(' ') }}</td>
                        <td><a href="{{ route('admin.roles.edit', $role) }}" class="button is-primary" style="margin-right: 3px;">Edit</a>
                        <a onclick="deteleRole({{ $role->id }})" class="button is-danger" style="margin-right: 3px;">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </section>

@endsection
