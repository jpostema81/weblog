@extends('layouts.master')

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">Home</a></li>
            <li class="is-active"><a href="#" aria-current="page">Category Add / Edit</a></li>
        </ul>
    </nav>

@endsection

@section('content')

    @if(!$category->id)
        {{ Form::model($category, ['route' => 'categories.store']) }}
    @else
        {{ Form::model($message, ['route' => ['categories.update', $category->id], 'method' => 'PUT']) }}
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

    <div class="control">
        {{ Form::submit("Save", array('class' => 'button is-primary')) }}
    </div>

    {{ Form::close() }}

@endsection
