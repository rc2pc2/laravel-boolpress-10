@extends('layouts.app')

@section('content')
<div class="container" id="posts-container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <h4 class="card-header">
                    {{ $post->user->name }}
                </h4>
                <h5 class="card-header"> ID: {{ $post->id }} ---- {{ $post->slug }} ---
                    {{ $post->category ? $post->category->name : '' }}</h5>

                @if ( count($post->tags) > 0)
                    <h6 class="card-header">
                        @foreach ($post->tags as $tag)
                            {{ $tag->name }} --
                        @endforeach
                    </h6>
                @endif

                @if (str_starts_with($post->image, 'http' ))
                    <img src="{{ $post->image }}" alt="{{ $post->title }}">
                @else
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                @endif

                <div class="card-body">
                    <h5 class="card-title">
                        {{ $post->title }}
                    </h5>
                    <p class="card-text">
                        {{ $post->content }}
                    </p>
                    <a href="{{ route('admin.posts.edit', $post ) }}" class="btn btn-sm btn-success">
                        Edit
                    </a>
                    <form class="d-inline-block" action="{{ route('admin.posts.destroy', $post ) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-sm btn-warning">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
