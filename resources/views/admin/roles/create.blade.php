@extends('layouts.master')

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Role Add / Edit</a></li>
        </ul>
    </nav>

@endsection

@section('content')

    @if(!$role->id)
        {{ Form::model($role, ['route' => 'admin.roles.store']) }}
    @else
        {{ Form::model($role, ['route' => ['admin.roles.update', $role->id], 'method' => 'PUT']) }}
    @endif

    <div class="field">
        {{ Form::label('name', 'Role name', array('class' => 'label')) }}
        <div class="control">
            {{ Form::text('name', null, $attributes = $errors->has('name') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('name')
            <p class="help is-danger">{{ $errors->first('name') }}</p>
        @enderror
    </div>

    <div class="field">
        {{ Form::label('permissions', 'Assign (at least 1) permission(s) to role (required)', array('class' => 'label')) }}

        <div class="control select is-multiple">
            @foreach($permissions as $permission)
                @if(!$role->id)
                    {{ Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
                @else
                    {{ Form::checkbox('permissions[]',  $permission->id ) }}
                @endif

                {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>
            @endforeach

            @error('permissions')
                <p class="help is-danger">{{ $errors->first('permissions') }}</p>
            @enderror
        </div>
    </div>

    <div class="control">
        {{ Form::submit("Save", array('class' => 'button is-primary')) }}
    </div>

    {{ Form::close() }}

@endsection
