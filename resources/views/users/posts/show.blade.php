@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <div class="row border shadow">
        {{-- LEFT SIDE --}}
    
        <div class="col-lg-8 col-md-8 col-sm-6 p-0 border-end">
            <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100">
        </div>
      
        {{-- RIGHT SIDE --}}
        <div class="col px-0 bg-white right-side-col">
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        {{-- image --}}
                        <div class="col-auto">
                            <a href="{{route('profile.show', $post->user->id)}}">
                                @if($post->user->avatar)
                                    <img src="{{$post->user->avatar}}" alt="{{$post->user->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        {{-- name --}}
                        <div class="col ps-0 text-truncate">
                            <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark">{{$post->user->name}}</a>
                        </div>
                        {{-- ellipsis --}}
                        <div class="col-auto">
                            {{-- if you are the owner of the post, display EDIT/DELETE menu. Else, display follow menu --}}
                            @if(Auth::user()->id === $post->user->id)
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{route('post.edit', $post->id)}}" class="dropdown-item">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </button>
                                    </div>
                                    @include('users.posts.contents.modals.delete')
                                </div>
                            @else
                                @if($post->user->isFollowed())
                                    <form action="{{route('follow.destroy', $post->user->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent p-0 text-secondary">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    <form action="{{route('follow.store', $post->user->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent p-0 text-primary">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body w-100 right-side-body">
                     {{-- heart button + number of likes + categories --}}
                    <div class="row align-item-center">
                        {{-- heart --}}
                        <div class="col-auto">
                            @if($post->isLiked())
                                {{-- removed the like --}}
                                <form action="{{route('like.destroy', $post->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm shadow-none p-0">
                                        <i class="fa-solid fa-heart text-danger"></i>
                                    </button>
                                </form>
                            @else
                                {{-- add like --}}
                                <form action="{{route('like.store', $post->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm shadow-none p-0">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        {{-- number of likes --}}
                        <div class="col-auto px-0">
                            <button type="button" class="btn btn-sm shadow-none p-0" data-bs-toggle="modal" data-bs-target="#numberOfLikes-{{$post->id}}">
                                <span class="fw-bold">{{$post->likes->count()}}</span>
                            </button>
                        </div>
                        {{-- include the modal here --}}
                        @include('users.posts.contents.modals.likes')
                        {{-- post categories --}}
                        <div class="col text-end">
                            {{-- @foreach ($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    {{$category_post->category->name}}
                                </div>
                            @endforeach --}}
                            @forelse($post->categoryPost as $category_post)
                                <span class="badge bg-secondary bg-opacity-50">
                                    {{$category_post->category->name}}
                                </span>
                            @empty
                                <div class="badge bg-dark text-wrap">Uncategorized</div>
                            @endforelse
                        </div>
                    </div>
                    {{-- post owner + description --}}
                    <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
                    &nbsp;
                    <p class="d-inline fw-light">{{$post->description}}</p>
                    {{-- <p class="text-uppercase text-muted xsmall">{{date('M d, Y', strtotime($post->created_at))}}</p> --}}
                    <p class="text-uppercase text-muted xsmall">{{$post->created_at->diffForHumans()}}</p>
                    
                    {{-- comments --}}
                    <div class="mt-4">
                        <form action="{{route('comment.store', $post->id)}}" method="POST">
                            @csrf
                            <div class="input-group">
                                <textarea name="comment_body{{$post->id}}" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{old('comment_body'.$post->id)}}</textarea>
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                            </div>
                            {{-- error --}}
                            @error('comment_body'.$post->id)
                                <div class="text-danger small">{{$message}}</div>
                            @enderror
                        </form>
                        {{-- Show all comments here --}}
                        @if($post->comments->isNotEmpty())
                            <ul class="list-group mt-2">
                                @foreach($post->comments as $comment)
                                    <li class="list-group-item border-0 mb-1 p-0 bg-white">
                                        <a href="{{route('profile.show', $comment->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$comment->user->name}}</a>

                                        &nbsp;
                                        <p class="d-inline fw-light">{{$comment->body}}</p>
                                        
                                        <form action="{{route('comment.destroy', $comment->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <span class="text-uppercase text-muted xsmall">{{$comment->created_at->diffForHumans()}}</span>

                                            @if(Auth::user()->id === $comment->user->id)
                                                &middot;
                                                <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                                            @endif
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection