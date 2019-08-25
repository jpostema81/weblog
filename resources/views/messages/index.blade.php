@extends('layouts.master')

@section('breadcrumbs')

@endsection

@section('content')

    <section>

        <br>
        
        <div class="box"> 
            <div class="level">
                <category-filter-component></category-filter-component>
            </div>
        </div>

        @foreach ($messages as $message)
            <div class="card article">
                <div class="card-content">
                    <div class="media">
                        <div class="media-content has-text-centered">
                            <p class="title is-4">
                                <a href="{{ route('messages.show', ['message' => $message->id]) }}">{{ $message->title }}</a>
                            </p>
                            <div class="tags has-addons level-item">
                                <span class="tag is-rounded is-info">@ {{ $message->user->name }}</span>

                                @if (count($message->categories) > 0)
                                    <span class="tag is-black">
                                        @foreach ($message->categories as $category)
                                            {{ $loop->last ? $category->name : $category->name . ', ' }}
                                        @endforeach
                                    </span>
                                @endif

                                <span class="tag is-rounded">{{ Carbon\Carbon::parse($message->created_at)->format('d-m-Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="content article-body">
                        {{ $message->content }}
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    
@endsection
