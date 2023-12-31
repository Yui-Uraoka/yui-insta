<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $user;
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function show($id) {
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')->with('user', $user);
    }

    public function edit() {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);

    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50|unique:users,email,'.Auth::user()->id,
            'avatar' => 'mimes:jpg,jpeg,gif,png|max:1048',
            'introduction' => 'max:100'
        ]);

        // To update the login user's information
        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        // To check if the request has an avatar
        if($request->avatar) {
            $user->avatar = 'data:image/'. $request->avatar->extension(). ';base64,'. base64_encode(file_get_contents($request->avatar));
        }

        $user->save();


        // Redirect
        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function followers($id) {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

    public function following($id) {
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }

    public function updatePassword(Request $request)
    {
        /**
         * This will pass the current_password_error displayed in the view via the session
         */
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return redirect()->back()->with('current_password_error', 'Your current password does not match with what you provided');
        }
 
          /**
           * This will pass the new_password_error displayed in the view via the session
           */

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            return redirect()->back()->with('new_password_error', 'Your current password cannot be the same as your new password');
        }

        $request->validate([
            'current_password' => 'required|string|min:8|max:50',
            'new_password' => 'required|string|min:8|max:50|confirmed',
            //the field under validation must have a matching field of {field}_confirmation => new_password_confirmation
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);

        $user->password = Hash::make($request->get('new_password'));

        $user->save();

        return redirect()->route('profile.show', Auth::user()->id )->with('success_password', 'Your password has been updated successfully');
    }

}
