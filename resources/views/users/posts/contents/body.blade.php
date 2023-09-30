{{-- clickable image --}}
<div class="container p-0">
    <a href="{{route('post.show', $post->id)}}">
        <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100">
    </a>
</div>
<div class="card-body">
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
    {{-- post owner + desctiption --}}
    <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
    &nbsp;
    <p class="d-inline fw-light">{{$post->description}}</p>
    {{-- <p class="text-uppercase text-muted xsmall">{{date('M d, Y', strtotime($post->created_at))}}</p> --}}
    <p class="text-uppercase text-muted xsmall">{{$post->created_at->diffForHumans()}}</p>

    {{-- comments --}}
    @include('users.posts.contents.comments')
</div>