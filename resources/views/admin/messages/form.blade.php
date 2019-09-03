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
        {{ Form::model($message, ['route' => 'admin.messages.store', 'files' => true]) }}
    @else
        {{ Form::model($message, ['route' => ['admin.messages.update', $message->id], 'method' => 'PUT', 'files' => true]) }}
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

    @if ($message->image != NULL)
    <div class="field">
        <figure>
            <img src="{{ asset('storage/'.$message->image) }}" alt="image" max>
        </figure>
    </div>
    @endif

    <div class="field">
        {{ Form::label('image', 'Image', array('class' => 'label')) }}

        <div class="control">
            {{ Form::file('image', null, $attributes = $errors->has('image') ? array('class' => 'input is-primary is-danger') : array('class' => 'input is-primary')) }}
        </div>
        @error('image')
            <p class="help is-danger">{{ $errors->first('image') }}</p>
        @enderror
    </div>

    <div class="field">
        {{ Form::label('category', 'Category', array('class' => 'label')) }}

        <div class="control select is-multiple">
            <select multiple="multiple" name="categories[]">
                @foreach(App\Category::all() as $category)
                    <option value="{{ $category->id }}" @if($message->categories->contains($category))selected="selected"@endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="control">
        {{ Form::submit("Save", array('class' => 'button is-primary')) }}
    </div>

    {{ Form::close() }}

@endsection
