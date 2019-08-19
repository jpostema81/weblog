@extends('layouts.master')

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Message Add / Edit</a></li>
        </ul>
    </nav>

@endsection

@section('content')

    @if(!$message->id)
        {{ Form::model($message, ['route' => 'admin.messages.store']) }}
    @else
        {{ Form::model($message, ['route' => ['admin.messages.update', $message->id], 'method' => 'PUT']) }}
    @endif

    <div class="field">
        {{ Form::label('title', 'Title', array('class' => 'label')) }}
        <div class="control">
            {{ Form::text('title', null, $attributes = $errors->has('title') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('title')
            <p class="help is-danger">{{ $errors->first('title') }}</p>
        @enderror
    </div>

    <div class="field">
        {{ Form::label('content', 'Content', array('class' => 'label')) }}

        <div class="control">
            {{ Form::textarea('content', null, $attributes = $errors->has('content') ? array('class' => 'input is-primary textarea is-danger', 'rows' => '4') : array('class' => 'input is-primary textarea', 'rows' => '4')) }}
        </div>
        @error('content')
            <p class="help is-danger">{{ $errors->first('content') }}</p>
        @enderror
    </div>

    <div class="control">
        {{ Form::submit("Save", array('class' => 'button is-primary')) }}
    </div>

    {{ Form::close() }}

@endsection
