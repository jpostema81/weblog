@extends('layouts.master')

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('admin.users.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">User Add / Edit</a></li>
        </ul>
    </nav>

@endsection

@section('content')

    @if(!$user->id)
        {{ Form::model($user, ['route' => 'admin.users.store']) }}
    @else
        {{ Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'PUT']) }}
    @endif

    <div class="field">
        {{ Form::label('name', 'Name', array('class' => 'label')) }}
        <div class="control">
            {{ Form::text('name', null, $attributes = $errors->has('name') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('name')
            <p class="help is-danger">{{ $errors->first('name') }}</p>
        @enderror
    </div>

    <div class="field">
        {{ Form::label('email', 'Email', array('class' => 'label')) }}

        <div class="control">
            {{ Form::text('email', null, $attributes = $errors->has('email') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('email')
            <p class="help is-danger">{{ $errors->first('email') }}</p>
        @enderror
    </div>

    <div class="field">
        {{ Form::label('role', 'Roles', array('class' => 'label')) }}

        <div class="control select is-multiple">
            @foreach($roles as $role)
                {{ Form::checkbox('roles[]', $role->id ) }}
                {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                {{-- @if($message->categories->contains($category))selected="selected"@endif --}}
            @endforeach
        </div>
    </div>

    <div class="field">
        {{ Form::label('password', 'Password', array('class' => 'label')) }}

        <div class="control">
            {{ Form::password('password', null, $attributes = $errors->has('password') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('password')
            <p class="help is-danger">{{ $errors->first('password') }}</p>
        @enderror
    </div>

    <div class="field">
        {{ Form::label('password_confirmation', 'Confirm password', array('class' => 'label')) }}

        <div class="control">
            {{ Form::password('password_confirmation', null, $attributes = $errors->has('password_confirmation') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('password_confirmation')
            <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
        @enderror
    </div>

   
    <div class="control">
        {{ Form::submit("Save", array('class' => 'button is-primary')) }}
    </div>

    {{ Form::close() }}

@endsection
