@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
    <div class="card bg-white mb-3 border-0 rounded-0">
        <div class="card-body">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-8 float-start">
                        <p class="fs-5 text-secondary">
                            <i class="fa-solid fa-tags"></i> Categories
                            <button type="button" class="btn btn-white btn-outline-light rounded-circle p-0 shadow-sm text-secondary border" data-bs-toggle="modal" data-bs-target="#addCategory" style="width:1.8rem;height:1.8rem;" title="Add a category...">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 float-end">
                        <form action="#" aria-labelledby="search-info">
                            <div class="input-group">
                                <input type="search" name="search" id="search" class="form-control" placeholder="Search categories">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <a href="{{route('admin.categories')}}" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                </a>
                            </div>
                        </form>
                        <div id="search-info" class="form-text text-end mb-2">
                            {{$categories->count()}} result(s) found
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive col-lg-12 col-md-12">
                    <table class="table table-hover align-middle bg-white border table-sm text-secondary text-center">
                        <thead class="table-warning small text-secondary">
                            <th>#</th>
                            <th>NAME</th>
                            <th>COUNT</th>
                            <th>LAST UPDATED</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td class="text-dark">{{$category->name}}</td>
                                    <td>{{$category->categoryPost->count()}}</td>
                                    <td>{{date('d/m/Y', strtotime($category->updated_at))}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6 text-end">
                                                <button class="btn btn-outline-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{$category->id}}" title="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-6 text-start">
                                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category-{{$category->id}}" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{$category->id}}" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category-{{$category->id}}" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td> --}}
                                </tr>
                                {{-- include the modal here --}}
                                @include('admin.categories.modal.action')
                            @empty
                                <tr>
                                    <td colspan="5" class="lead text-muted text-center">No categories found.</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td></td>
                                <td class="text-dark">
                                    Uncategorized
                                    <p class="xsmall mb-0 text-muted">Hidden posts are not included.</p>
                                </td>
                                <td>{{$uncategorized_count}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>                   
                </div>
            </div>
             {{-- <div class="d-flex justify-content-center">
                        {{$categories->links()}}
                    </div> --}}
        </div>
    </div>
@endsection