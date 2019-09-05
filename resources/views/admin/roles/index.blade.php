@extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('admin.roles..index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Roles Overview</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    <section>
        <a href="{{ route('admin.roles.create') }}" class="button is-primary">Create new role</a>

        <br><br>
        
        <table class="table">
            <thead>
                <th>Role</th>
                <th>Permissions</th>
                <th>Operation</th>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->permissions()->pluck('name')) }}</td>
                    <td><a href="{{ route('admin.roles.edit', $role) }}">edit</a></td>
                    <td><a onclick="deteleRole({{ $role->id }})">delete</a></td>
                </tr></a>
                @endforeach
            </tbody>

        </table>
    </section>

@endsection
