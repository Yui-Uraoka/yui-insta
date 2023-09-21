@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    {{-- @foreach ($selected_categories as $category)
        <p>{{$category}}</p>
    @endforeach --}}
    <form action="{{route('post.update', $post->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        {{-- Checkboxes for categories --}}
        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category <span class="text-muted fw-normal">(up to 3)</span>
            </label>
            @foreach($all_categories as $category)
                <div class="form-check form-check-inline">
                    @if(in_array($category->id, $selected_categories))
                        <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input" checked>
                    @else
                        <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
                    @endif
                        <label for="{{$category->name}}" class="form-check-label">{{$category->name}}</label>
                </div>
            @endforeach
            {{-- Error --}}
            @error('category')
                <div class="text-danger small">{{$message}}</div>
            @enderror
        </div>
        {{-- description --}}
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="what's on your mind">{{old('description', $post->description)}}</textarea>
            {{-- Error --}}
            @error('description')
                <div class="text-danger small">{{$message}}</div>
            @enderror
        </div>

        {{-- Image --}}
        <div class="row mb-4">
            <div class="col-6">
                <label for="image" class="form-label fw-bold">Image</label>
                <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100 mb-3 img-thumbnail">
                <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
                <div id="image-info" class="form-text">
                    The accepptable formats are jpeg, jpg, png, and gif only. <br>
                    Max file size is 1048kB.
                </div>
            {{-- Error --}}
            @error('image')
                <div class="text-danger small">{{$message}}</div>
            @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endsection