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
                       0 result(s) found
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
                        <tr>
                            <td colspan="7" class="lead text-muted text-center">
                                No posts found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>        
    
    {{-- <div class="d-flex justify-content-center">
        {{$all_posts->links()}}
    </div> --}}
@endsection