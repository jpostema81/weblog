 @extends('layouts.master')

<!-- Bulma template source @ https://bulmatemplates.github.io/bulma-templates/templates/blog.html -->

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('admin.users.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Users Overview</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    <section>
        <a href="{{ route('roles.index') }}" class="button is-primary">Roles</a>
        <a href="{{ route('permissions.index') }}" class="button is-primary">Permissions</a></h1>

        <br><br>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date/Time Added</th>
                    <th>User Roles</th>
                    <th>Operations</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td> <!-- Retrieve array of roles associated to a user and convert to string -->
                    <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="button is-primary" style="margin-right: 3px;">Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'button is-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('users.create') }}" class="button is-primary">Add User</a>
    </section>

@endsection
