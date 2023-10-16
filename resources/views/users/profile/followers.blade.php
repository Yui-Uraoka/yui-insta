@extends('layouts.app')

@section('title', 'Followers')

@section('content')
    @include('users.profile.header')
    @if($user->followers->isNotEmpty())
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-8 col-12">
                <h3 class="text-muted text-center">Follower</h3>
                @foreach ($user->followers as $follower)
                <div class="row align-items-center mt-3">
                    {{-- icon/image --}}
                    <div class="col-auto">
                        <a href="{{route('profile.show', $follower->follower->id)}}">
                            @if($follower->follower->avatar)
                                <img src="{{$follower->follower->avatar}}" alt="{{$follower->follower->name}}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    {{-- name --}}
                    <div class="col ps-0 text-truncate">
                        <a href="{{route('profile.show', $follower->follower->id)}}" class="text-decoration-none text-dark fw-bold">
                            {{$follower->follower->name}}
                        </a>
                    </div>
                    {{-- follow/following button --}}
                    <div class="col-auto text-end">
                        @if($follower->follower->id != Auth::user()->id)
                            @if($follower->follower->isFollowed())
                                <form action="{{route('follow.destroy', $follower->follower->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm">
                                        Following
                                    </button>
                                </form>
                            @else
                                <form action="{{route('follow.store', $follower->follower->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">
                                        Follow
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>  
            @endforeach
            </div>
        </div>
    @else
        <h3 class="text-muted text-center">No Follower yet.</h3>
    @endif
@endsection