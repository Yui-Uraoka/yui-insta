@extends('layouts.app')

@section('title', 'Admin:Posts')
    
@section('content')

{{-- {{$postByCategory}} --}}
    <div class="card bg-white mb-3 border-0 rounded-0">
        <div class="card-body">
            <div class="row">
                <div class="col-8 float-start">
                    <p class="fs-5 text-secondary">
                        <i class="fa-solid fa-newspaper"></i> Posts
                    </p>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-12 float-end mb-2">
                    <form action="{{route('admin.posts.search')}}" aria-labelledby="search-info">
                        <div class="input-group">
                            <input type="search" name="search" id="search" class="form-control" placeholder="Search posts">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                           <a href="{{route('admin.posts')}}" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                            </a>
                        </div>
                    </form>
                    <div id="search-info" class="form-text text-end mb-2">
                        {{$post_count}} result(s) found
                    </div>
                </div>
            </div>
            <div class="table-responsive col-lg-12 col-md-12">
                <table class="table table-hover align-middle bg-white border text-secondary">
                    <thead class="small table-primary text-secondary">
                        <tr>
                            {{-- post_id --}}
                            <th></th>
                            {{-- image --}}
                            <th></th>
                            <th>CATEGORY</th>
                            <th>OWNER</th>
                            <th>CREATED AT</th>
                            <th>STATUS</th>
                            {{-- ellipsis --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($all_posts as $post)
                            <tr>
                                <td class="text-end">{{$post->id}}</td>
                                <td>
                                    <a href="{{route('post.show', $post->id)}}">
                                        <img src="{{$post->image}}" alt="post id {{$post->id}}" class="d-block mx-auto image-lg">
                                    </a>
                                </td>
                                <td>
                                    
                                    @forelse($post->categoryPost as $category_post)
                                        <span class="badge bg-secondary bg-opacity-50">
                                            {{$category_post->category->name}}
                                        </span>
                                    @empty
                                        <div class="badge bg-dark text-wrap">Uncategorized</div>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{route('profile.show', $post->user->id)}}" class="text-dark text-decoration-none">
                                        {{$post->user->name}}
                                    </a>
                                </td>
                                <td>{{date('d/m/Y', strtotime($post->created_at))}}</td>
                                {{-- status --}}
                                <td>
                                    @if($post->trashed())
                                        <i class="fa-solid fa-circle-minus text-secondary"></i>&nbsp;Hidden
                                    @else
                                        <i class="fa-solid fa-circle text-primary"></i>&nbsp;Visible
                                    @endif
                                </td>
                                {{-- ellipsis --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                
                                        <div class="dropdown-menu">
                                            @if($post->trashed())
                                                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#unhide-post-{{$post->id}}">
                                                    <i class="fa-solid fa-eye"></i> Unhide Post {{$post->id}}
                                                </button>
                                            @else
                                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                                    <i class="fa-solid fa-eye-slash"></i> Hide Post {{$post->id}}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Include modal here --}}
                                    @include('admin.posts.modal.status')
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="lead text-muted text-center">
                                        No posts found.
                                    </td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>        
    
    {{-- <div class="d-flex justify-content-center">
        {{$all_posts->links()}}
    </div> --}}
@endsection