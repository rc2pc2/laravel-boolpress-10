@extends('layouts.app')

@section('content')
<div class="container" id="posts-container">
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-5">
                    <label for="title" class="form-label">
                        Title
                    </label>
                    <input type="text" class="form-control" id="title" placeholder="Insert your post's title" name="title"  value="{{ old('title', '') }}">
                </div>


                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-5">
                    <label for="category_id" class="form-label">
                        Category
                    </label>
                    <select class='form-select' name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            @error('tag_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-5">
                <label for="tags" class="form-label">
                    Tags
                </label>

                <div>
                    @foreach ($tags as $tag)
                        <input type="checkbox" name="tags[]" class="form-check-input" id="tags" value="{{ $tag->id }}" @if( in_array($tag->id, old('tags', []))) checked @endif>
                        <label for="tags" class="form-check-label me-3">
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>



                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-5">
                    <label for="image" class="form-label">
                        Image
                    </label>
                    {{-- <input type="text" class="form-control" id="image" placeholder="https://ginetto-va-in-campagna-col-cappello.jpg" name="image"> --}}
                    <input type="file" name="image" id="image" class="form-control" placeholder="Upload your image" value="{{ old('image', '') }}">
                </div>

                @error('content')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-5">
                    <label for="content" class="form-label">
                        Content
                    </label>
                    <textarea class="form-control" id="content" rows="7" name="content">{{ old('content', '') }}</textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="me-3">
                        Create new post
                    </button>
                    <button type="reset">
                        Reset
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
