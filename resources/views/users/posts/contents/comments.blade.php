<div class="mt-3">
    {{-- Show all comments here --}}
    @if($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group">
            @foreach($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 mb-1 p-0">
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
            @if($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{route('post.show', $post->id)}}" class="text-decoration-none small">
                        View all {{$post->comments->count()}} comments
                    </a>
                </li>
            @endif
        </ul>
    @endif
    <form action="{{route('comment.store', $post->id)}}" method="POST">
        @csrf
        <div class="input-group">
            {{-- 
                We use name = "comment_body{{$posst->id}}" so that we can use the same name for all comment_body fields and we add the post id to make it unique. The purpose of this is to make the error message unique for each comment_body field.
                 --}}
            <textarea name="comment_body{{$post->id}}" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{old('comment_body'.$post->id)}}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
        </div>
        {{-- error --}}
        @error('comment_body'.$post->id)
            <div class="text-danger small">{{$message}}</div>
        @enderror
    </form>
</div>