@extends('layouts.app')

@section('title', 'create Post')

@section('content')
    <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Checkboxes for categories --}}
        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category <span class="text-muted fw-normal">(up to 3)</span>
            </label>
            @foreach($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
                     {{-- [1,2] --}}
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
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="what's on your mind">{{old('description')}}</textarea>
            {{-- Error --}}
            @error('description')
                <div class="text-danger small">{{$message}}</div>
            @enderror
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label for="image" class="form-label fw-bold">Image</label>
            <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
            <div id="image-info" class="form-text">
                The accepptable formats are jpeg, jpg, png, and gif only. <br>
                Max file size is 1048kB.
                {{-- B= bytes, b= bits 
                    1048kB = 1MB
                    1011 1100 = 8bits, bytes = group of 4bits
                    --}}
            </div>
            {{-- Error --}}
            @error('image')
                <div class="text-danger small">{{$message}}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary px-5">Post</button>
    </form>
@endsection
    
