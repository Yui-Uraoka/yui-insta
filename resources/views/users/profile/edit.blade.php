@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
   <div class="row justify-content-center">
    <div class="col-lg-8 col-md-12 col-sm-12">
            <form action="{{route('profile.update')}}" method="POST" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <h2 class="h3 mb-3 fw-light text-muted">Update Profile</h2>
                <div class="row mb-3">
                    <div class="col-4">
                        @if($user->avatar)
                            <img src="{{$user->avatar}}" alt="{{$user->name}}" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1" aria-describedby="avatar-info">
                        <div id="avatar-info" class="form-text">
                            Accecptable formats: jpeg, jpg, png, gif only <br>
                            Max file size is 1048kB
                        </div>
                        {{-- error --}}
                        @error('avatar')
                            <p class="text-danger small">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name', $user->name)}}" autofocus>
                    {{-- error --}}
                    @error('name')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-Mail Address</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email', $user->email)}}">
                    {{-- error --}}
                    @error('email')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                   <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{old('introduction', $user->introduction)}}</textarea>
                    {{-- error --}}
                    @error('introduction')
                        <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning px-5">Save</button>
            </form>

            {{-- change password --}}
            <form action="{{ route('profile.updatePassword') }}" method="POST" class="bg-white shadow rounded-3 p-5 mt-5">
                @csrf
                @method('PATCH')
                <h2 class=" fw-light mb-3 text-muted">Update Password</h2>
                {{-- current password --}}
                <div class="mb-3">
                    <label for="current-password" class="form-label fw-bold">Current Password</label>
                    <input type="password" name="current_password" id="current-password" class="form-control">

                    {{-- error --}}
                    @if (session('current_password_error'))
                        <p class="text-danger small">
                            {{ session('current_password_error') }}
                        </p>
                    @endif
                    @error('current_password')
                        <div class="text-danger small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- new password --}}
                <div class="mb-3">
                    <label for="new-password" class="form-label fw-bold">New Password</label>
                    <input type="password" name="new_password" id="new-password" class="form-control" aria-describedby="password-info">

                    <div id="password-info" class="form-text">
                        Password must be at least 8 characters long and contains numbers and letters.
                    </div>
                    @if (session('new_password_error'))
                        <p class="text-danger small">
                            {{ session('new_password_error') }}
                        </p>
                    @endif

                    {{-- error --}}
                    @error('new_password')
                        <div class="text-danger small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- confirm password --}}
                <div class="mb-3">
                    <label for="new-password-confirmation" class="form-label fw-bold">Confirm Password</label>
                    <input type="password" name="new_password_confirmation" id="new-password-confirmation" class="form-control">
                        
                        {{-- error --}}
                        @error('new_password_confirmation')
                            <div class="text-danger small">
                                {{ $message }}
                            </div>
                        @enderror
                </div>
                {{-- submit --}}
                <button type="submit" class="btn btn-warning px-5">Update Password</button>
            </form>
        </div>
   </div>
@endsection