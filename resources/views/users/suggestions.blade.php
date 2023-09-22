@extends('layouts.app')

@section('title', 'Suggested Users')

@section ('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <p class="fw-bold">Suggested</p>
            @forelse ($suggested_users as $user)
                    <div class="row align-item-center mb-3">
                        {{-- image --}}
                        <div class="col-auto">
                            <a href="{{route('profile.show', $user->id)}}">
                                @if($user->avatar)
                                    <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-md">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                                @endif
                            </a>
                        </div>
                        {{-- name --}}
                        <div class="col ps-0 text-truncate">
                            <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                                {{$user->name}}
                            </a>
                            <div class="text-muted">{{$user->email}}</div>
                            {{-- Followers' count --}}
                            @if($user->isFollowing())
                                <div class="text-muted xsmall">
                                    Follows you
                                </div>
                            @elseif($user->followers->isNotEmpty())
                                <div class="text-muted xsmall">
                                    {{$user->followers->count()}} followers
                                </div>
                            @else 
                                <div class="text-muted xsmall">
                                    No Followers yet
                                </div>
                            @endif
                            
                        </div>
                        {{-- follow button --}}
                        <div class="col-auto">
                            <form action="{{route('follow.store', $user->id)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Follow
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <h3 class="text-muted text-center">No Suggested Users.</h3>
                @endforelse
        </div>
    </div>

    {{-- checking --}}
@endsection