{{-- Hide a Post --}}
<div class="modal fade" id="hide-post-{{$post->id}}">
    <div class="modal-dialog">
      <div class="modal-content border-danger">
        <div class="modal-header border-danger">
          <h3 class="modal-title fs-5 text-danger">
            <i class="fa-solid fa-eye-slash"></i> Hide Post
          </h3>
        </div>
        <div class="modal-body">
          Are you sure you want to hide this post?
          <div class="mt-3">
            <img src="{{$post->image}}" alt="{{$post->id}}" class="image-lg">
            <p class="mt-1 text-secondary"> {{$post->description}}</p>
          </div>
        </div>
        <div class="modal-footer border-0">
            <form action="{{route('admin.posts.hide', $post->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm">Hide</button>
            </form>
        </div>
      </div>
    </div>
</div>

{{-- Unhide a Post --}}
<div class="modal fade" id="unhide-post-{{$post->id}}">
    <div class="modal-dialog">
      <div class="modal-content border-primary">
        <div class="modal-header border-primary">
          <h3 class="modal-title fs-5 text-primary">
            <i class="fa-solid fa-eye"></i> Unhide Post
          </h3>
        </div>
        <div class="modal-body">
          Are you sure you want to hide this post?
          <div class="mt-3">
            <img src="{{$post->image}}" alt="{{$post->id}}" class="image-lg">
            <p class="mt-1 text-secondary"> {{$post->description}}</p>
          </div>
        </div>
        <div class="modal-footer border-0">
            <form action="{{route('admin.posts.unhide', $post->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Unhide</button>
            </form>
        </div>
      </div>
    </div>
</div>