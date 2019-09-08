@extends('layouts.master')

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('admin.permissions.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Permission Add / Edit</a></li>
        </ul>
    </nav>

@endsection

@section('content')
    @if(is_null($permission->id))
        {{ Form::model($permission, ['route' => 'admin.permissions.store']) }}
    @else
        {{ Form::model($permission, ['route' => ['admin.permissions.update', $permission->id], 'method' => 'PUT']) }}
    @endif

    <div class="field">
        {{ Form::label('name', 'Permission name', array('class' => 'label')) }}
        <div class="control">
            {{ Form::text('name', null, $attributes = $errors->has('name') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('name')
            <p class="help is-danger">{{ $errors->first('name') }}</p>
        @enderror
    </div>

    @if(!$roles->isEmpty()) {{-- If no roles exist yet --}}
        <div class="field">
            {{ Form::label('roles', 'Assign roles to permission (optional)', array('class' => 'label')) }}

            <div class="control select is-multiple">
                @foreach($roles as $role)
                    {{ Form::checkbox('roles[]',  $role->id ) }}
                    {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                @endforeach
            </div>
        </div>
    @endif
    
    <div class="control">
        {{ Form::submit("Save", array('class' => 'button is-primary')) }}
    </div>

    {{ Form::close() }}

@endsection
