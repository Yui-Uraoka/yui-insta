@extends('layouts.app')

@section('title', 'Admin:Users')

@section('content')
    <div class="card bg-white mb-3 border-0 rounded-0">
        <div class="card-body">
            <div class="row">
                <div class="col float-start">
                    <p class="fs-5 text-secondary">
                        <i class="fa-solid fa-users"></i> Users
                    </p>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-12 float-end mb-2">
                    <form action="{{route('admin.users.search')}}" aria-labelledby="search-info">
                        <div class="input-group">
                            <input type="search" name="search" id="search" class="form-control" placeholder="Search users">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                           <a href="{{route('admin.users')}}" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                            </a>
                        </div>
                    </form>
                    {{-- <div id="search-info" class="form-text text-end mb-2">
                        {{$all_users->count()}} result(s) found
                    </div> --}}
                </div>
            </div>

            {{-- table --}}
            <div class="table-responsive col-lg-12 col-md-12">
                <table class="table table-hover align-middle bg-white border text-secondary">
                    <thead class="small table-success text-secondary">
                        <tr>
                            {{-- avatar --}}
                            <th></th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>CREATED AT</th>
                            <th>STATUS</th>
                            {{-- ellipsis --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_users as $user)
                            <tr>
                                {{-- image --}}
                                <td>
                                    @if($user->avatar)
                                        <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle d-block mx-auto avatar-md">
                                    @else
                                        <i class="fa-solid fa-circle-user d-block text-center icon-md"></i>
                                    @endif
                                </td>
                                {{-- Name --}}
                                <td>
                                    <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">{{$user->name}}</a>
                                </td>
                                {{-- Email --}}
                                <td>
                                    {{$user->email}}
                                </td>
                                {{-- created at --}}
                                <td>
                                    {{-- {{date('l jS \of F Y h:i:s A', strtotime($user->created_at))}} --}}
                                    {{date('d/m/Y', strtotime($user->created_at))}}
                                </td>
                                {{-- status --}}
                                <td>
                                    {{-- 
                                        trashed() is to check if the user is softdeleted
                                        this will check the deleted_at column in the users table
                                        if the value = NULL, it will return FALSE
                                        if the value = timestamp, it will return TRUE
                                        --}}
                                    @if($user->trashed())
                                        <i class="fa-solid fa-circle text-secondary"></i>&nbsp;Inactive
                                    @else
                                        <i class="fa-solid fa-circle text-success"></i>&nbsp;Active
                                    @endif
                                </td>
                                {{-- ellipsis --}}
                                <td>
                                    {{--  --}}
                                    @if(Auth::user()->id !== $user->id)
                                        <div class="dropdown">
                                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
            
                                            <div class="dropdown-menu">
                                                @if($user->trashed())
                                                    <button class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#activate-user-{{$user->id}}">
                                                        <i class="fa-solid fa-user-check"></i> Activate {{$user->name}}
                                                    </button>
                                                @else
                                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{$user->id}}">
                                                        <i class="fa-solid fa-user-slash"></i> Deactivate {{$user->name}}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Include modal here --}}
                                        @include('admin.users.modal.status')
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center">
        {{$all_users->links()}}
    </div>
@endsection

