<div class="modal fade" id="numberOfLikes-{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-success text-center">
            <div class="modal-header border-success justify-content-center">
                <h3 class="h5 modal-title">
                    <i class="fa-solid fa-heart text-danger"></i> Likes
                </h3>
            </div>
            <div class="modal-body">
                @forelse($post->likes as $like)
                    <div class="row mb-2 float-center">
                        <div class="col-5 text-end">
                            <a href="{{route('profile.show', $like->user->id)}}" class="text-decoration-none">
                                @if($like->user->avatar)
                                    <img src="{{$like->user->avatar}}" alt="{{$like->user->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col text-start">
                            <a href="{{route('profile.show', $like->user->id)}}" class="text-decoration-none text-dark">
                                {{$like->user->name}}
                            </a>
                        </div>
                    </div>
                @empty
                    No likes found
                @endforelse
            </div>
        </div>
    </div>
</div>